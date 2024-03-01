<?php
namespace Malla\Navy\Database\Seed;

/*
 *---------------------------------------------------------
 * ©IIPEC
 * Santo Domingo República Dominicana.
 *---------------------------------------------------------
*/

use Malla\Navy\Model\Store;
use Malla\Taxonomy\Model\Term;
use Illuminate\Database\Seeder;

class NavySeed extends Seeder {

   public function run() {

      // $term = (new Term)->create([
      //    "type"   => "navy",
      //    "slug"   => "admin-dashboard",
      //    "name"   => "Admin Dashboard",
      // ]);

      // $menu = (new Store)->create([
      //    "icon"   => "mdi-account-circle",
      //    "label"  => "words.users",
      //    "url"    => "admin/users"
      // ]);

      // $term->syncObj($menu->id, )

      // $menu = (new Store)->create([
      //    "icon"   => "mdi-web",
      //    "label"  => "words.applications",
      //    "url"    => "admin/app"
      // ]);
      // $menu = (new Store)->create([
      //    "parent" => $menu->id,
      //    "icon"   => "mdi-cog",
      //    "label"  => "words.configs",
      //    "url"    => "admin/configs"
      // ]);
      // $menu = (new Store)->create([
      //    "parent" => $menu->id,
      //    "icon"   => "mdi-cog",
      //    "label"  => "words.configs",
      //    "url"    => "admin/configs"
      // ]);

   }


}