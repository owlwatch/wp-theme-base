<?php

class Theme_Util_FolioParser
{
  protected $url = '';
  protected $info=array();
  protected $space = 'S_P_A_C_E';
  protected $_prefix = 'folio_';
  
  public function get_faculty_list( $url )
  {
    if( !$url ) throw new Exception("No Folio URL provided");
    
    libxml_use_internal_errors(true);
    set_time_limit(-1);
    
    $this->_load_document( $url );
    
    // now lets parse this baby out...
    $links = $this->xpath->evaluate("//td[contains(@class, 'views-field-field-ulname-value')]//a[contains(@href, 'faculty/')]");
    $faculty = array();
    
    foreach( $links as $link ){
      $u = $link->attributes->getNamedItem('href')->nodeValue;
      $u = dirname( $url ).'/'.$u;
      $n = trim($link->nodeValue);
      if( !array_key_exists($u, $faculty) && $n != ', '){
        $faculty[$u] = array('name'=>$n, 'url' => $u);
      }
    }
    
    $links = $this->xpath->evaluate("//div[contains(@id, 'block-views-View_all_profile-block_1')]//td[contains(@class, 'views-field-field-ulname-value')]//a[contains(@href, 'faculty/')]");
    foreach( $links as $link ){
      $u = $link->attributes->getNamedItem('href')->nodeValue;
      $u = dirname( $url ).'/'.$u;
      $n = trim($link->nodeValue);
      
      if( $n != ', ' && array_key_exists($u, $faculty) ){
        $faculty[$u]['folio_tenure'] = true;
      }
      else if( $n != ', ' ) {
        $faculty[$u] = array(
          'name'    => $n,
          'url'     => $u,
          'tenure'  => true
        );
      }
    }
    $faculty = array_filter( $faculty, function($item){
      return basename( $item['url'] ) != '_';
    });
    
    return $faculty;
    
  }
  
  public function parse_faculty_member( $url )
  {
    if( !$url ) throw new Exception("No Folio URL provided");
    
    libxml_use_internal_errors(true);
    
    
    $this->_load_document( $url );
    $this->topNode = $this->doc->getElementById('researchcontentdetail');
    
    $this->info = array();
    
    // General profile stuff
    $this->parse_profile_info();
    
    // Generic tables
    $this->parse_generic_table('education', 'view-id-faculty_education');
    $this->parse_generic_table('experience', 'view-id-faculty_experience');
    $this->parse_generic_table('research_areas', 'view-id-Faculty_Search_Research_Areas');
    $this->parse_generic_table('awards', 'view-id-Faculty_Search_Awards_Honors');
    $this->parse_generic_table('presentations', 'view-id-public_search_presentation');
    $this->parse_generic_table('committees', 'view-id-public_search_committees');
    
    // Ok... now onto publications...
    $url = preg_replace('#/faculty/#', '/faculty_publications/', $url );
    $this->_load_document( $url, '&nbsp;', $this->space );
    $this->topNode = $this->doc->getElementById('researchcontentdetail');
    
    $this->parse_generic_table('journal_articles', 'view-id-Faculty_Search_Journal_Articles', array(&$this, 'parse_publication_value') );
    $this->parse_generic_table('books', 'view-id-Faculty_Search_Jou_Books', array(&$this, 'parse_publication_value') );
    $this->parse_generic_table('book_chapters', 'view-id-Faculty_Search_Jou_Book_Chapters', array(&$this, 'parse_publication_value') );
    $this->parse_generic_table('other_publications', 'view-id-Faculty_Search_Jou_Other', array(&$this, 'parse_publication_value') );
    $this->parse_generic_table('conference_proceedings', 'view-id-Faculty_Search_Conf_Proceedings', array(&$this, 'parse_publication_value') );
    $this->parse_generic_table('patents', 'view-id-Faculty_Search_Jou_Patents', array(&$this, 'parse_patent_value') );
    
    return $this->prefix($this->info);
  }
  
  protected function prefix( $source )
  {
    $prefixed = array();
    foreach( $source as $key => $value ){
      $prefixed[$this->_prefix.$key] = $value;
    }
    return $prefixed;
  }
  
  protected function parse_profile_info()
  {
    
    $nodes = $this->xpath->evaluate('//*'.$this->_xpath_class('views-field-field-ufname-value'), $this->topNode);
    
    if( $nodes->length ){
      $node = $nodes->item(0);
      $this->info['profile'] = $this->_inner_html( $node );
      
      // get the title...
      $parts = explode('<br>', $this->info['profile'] );
      $this->info['title'] = $parts[1];
      $this->info['department'] = $parts[2];
      
      // look for a researcher id
      $links = $this->xpath->evaluate("//a[contains(@href,'researcherid.com/rid')]", $node);
      if( $links->length ){
        $this->info['researcherid_url'] = $links->item(0)->attributes->getNamedItem('href')->nodeValue;
      }
      
      // look for email address
      $emails = $this->xpath->evaluate("//a[contains(@href, 'mailto:')]", $node);
      if( $emails->length ){
        $this->info['email'] = preg_replace('/^mailto\:/', '', $emails->item(0)->attributes->getNamedItem('href')->nodeValue );
      }
    }
    else {
      throw new Exception("Invalid HTML structure");
    }
  }
  
  protected function parse_patent_value( $node )
  {
    $patent = array();
    $patent['original'] = trim( str_replace( $this->space, ' ', $this->_inner_html( $node ) ) );
    
    $texts = $this->xpath->evaluate('./text()', $node);
    $str = array();
    foreach( $texts as $text ){
      $str[] = trim( $text->nodeValue );
    }
    $str = implode(' ', $str);
    $parts = explode( $this->space, $str );
    $props = array('authors', 'name', 'patent_numbers', 'year');
    
    
    while( count($parts) && count($props) ) $patent[ array_shift($props) ] = array_shift($parts);
    
    // how bout them links
    $a = $this->xpath->evaluate(".//a[contains(@href,'dx.doi.org')]", $node);
    if( $a->length ){
      $patent['doi_url'] = $a->item(0)->attributes->getNamedItem('href')->nodeValue;
    }
    
    $a = $this->xpath->evaluate(".//a[contains(@href,'isiknowledge.com')]", $node);
    if( $a->length ){
      $patent['web_of_science_url'] = $a->item(0)->attributes->getNamedItem('href')->nodeValue;
    }
    
    return $patent;
    
  }
  
  protected function parse_publication_value( $node )
  {
    $pub = array();
    $pub['original'] = trim( str_replace( $this->space, ' ', $this->_inner_html( $node ) ) );
    
    $i = $this->xpath->evaluate('.//i', $node);
    
    // the first text node is the authors, year, and article
    $texts = $this->xpath->evaluate('./text()', $node);
    $str = array();
    foreach( $texts as $text ){
      $str[] = trim( $text->nodeValue );
    }
    $str = implode(' ', $str);
    
    $parts = explode( $this->space, $str );
    
    $pub['authors'] = preg_replace('/, .$/', '', array_shift($parts));
    if( count($parts) ){
      $next = array_shift($parts);
      if( preg_match('#\((\d+)\)#', $next, $matches ) ){
        $pub['year'] = $matches[1];
      }
      else {
        array_unshift( $parts, $next );
      }
    }
    
    if( count($parts) ){
      $pub['article'] = array_shift($parts);
    }
    
    if( count($parts) ){
      
      
      // burn the period after the article
      array_shift( $parts );
      
      // first thing is volume
      $pub['volume'] = trim( array_shift( $parts ), '. ' );
      if( count( $parts ) ){
        
        // then page number
        $pub['page_numbers'] = trim( array_shift( $parts ), '. ' );
      }
    }
    
    if( $i->length ) $pub['publication'] = $i->item(0)->nodeValue;
    
    // how bout them links
    $a = $this->xpath->evaluate(".//a[contains(@href,'dx.doi.org')]", $node);
    if( $a->length ){
      $pub['doi_url'] = $a->item(0)->attributes->getNamedItem('href')->nodeValue;
    }
    
    $a = $this->xpath->evaluate(".//a[contains(@href,'isiknowledge.com')]", $node);
    if( $a->length ){
      $pub['web_of_science_url'] = $a->item(0)->attributes->getNamedItem('href')->nodeValue;
    }
    
    return $pub;
  }
  
  /**
   * Loop through ugly drupal "views"... gross.
   */
  protected function parse_generic_table($key, $class, $callback = null)
  {
    $path = array(
      'div'.$this->_xpath_class($class),
      'tbody',
      'td'.$this->_xpath_class('views-field')
    );
    
    $nodes = $this->xpath->evaluate('.//'.implode('//',$path), $this->topNode);
    if( !$nodes->length ) return;
    
    $this->info[$key] = array();
    foreach( $nodes as $node ){
      $this->info[$key][] = ( $callback && is_callable( $callback ) ) ?
        call_user_func( $callback, $node ) :
        trim( $this->_inner_html( $node ) );
    }
  }
  
  /**
   * Load a document into our parser
   */
  protected function _load_document( $url, $search=array(), $replace=array() )
  {
    $url = str_replace(' ', '%20', $url );
    
    $content = file_get_contents( $url );
    if( !$content ) throw new Exception( "No content" );
    
    // lets see how possible it is to parse this as an xml document...
    $this->doc = new DOMDocument();
    $this->doc->loadHTML( str_replace($search, $replace, $content) );
    
    // create an xpath to query with
    $this->xpath = new DOMXPath( $this->doc );
    
  }
  
  
  /**
   * Shortcut function to create a css class selector
   *
   * @param string classname
   * @return string attribute selection string
   */
  protected function _xpath_class( $classname )
  {
    return "[contains(concat(' ',normalize-space(@class),' '),' $classname ')]";
  }
  
  /**
   * innerHTML style function
   *
   * @param DOMNode node
   * @returns string the inner html string
   */
  protected function _inner_html( $node )
  {
    $html = $node->ownerDocument->saveHTML( $node );
    $start = stripos($html, '>')+1;
    return substr( $html, $start, strrpos($html, '<')-$start-1);
  }
}
