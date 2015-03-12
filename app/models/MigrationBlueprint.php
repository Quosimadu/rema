<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 12/03/2015
 * Time: 08:13
 */

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;


class MigrationBlueprint extends Blueprint {


    /**
     * Indicate that the user columns should be dropped.
     *
     * @return void
     */
    public function dropUsers()
    {
        $this->dropColumn('create_user_id', 'last_change_user_id');
    }

    /**
     * Add creation and update user data to the table.
     *
     * @return void
     */
    public function users()
    {
        $this->integer('create_user_id')->unsigned();
        $this->integer('last_change_user_id')->unsigned();
    }

}