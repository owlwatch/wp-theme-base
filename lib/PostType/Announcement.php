<?php
/**
 * Announcement post type
 *
 * @wp.posttype.name                        announcement
 * @wp.posttype.single                      Announcement
 * @wp.posttype.plural                      Announcements
 *
 * @wp.posttype.args.menu_position          4
 * @wp.posttype.args.rewrite.slug           announcements
 * @wp.posttype.args.rewrite.with_front     false
 *
 * @wp.posttype.supports.revisions          true
 * @wp.posttype.supports.thumbnail          true
 * @wp.posttype.supports.excerpt            true
 * @wp.posttype.supports.post-formats       true
 *
 */
class Theme_PostType_Announcement extends Snap_Wordpress_PostType
{
  /**
   * @wp.action         init
   * @wp.priority       300
   */
  public function register_taxonomies()
  {
    register_taxonomy_for_object_type('category', $this->name);
    register_taxonomy_for_object_type('post_tag', $this->name);
  }
}
