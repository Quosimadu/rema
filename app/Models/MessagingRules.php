<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 08/05/2017
 * Time: 20:26
 */

namespace App\Models;


class MessagingRules
{

    /**
     * @return array
     */
    public static function forwardingRules(): array
    {

        $forwardingTargets = [];


        $forwardingTargets['+447520635886'][] = ['receiver' => '+420778001155'];
        $forwardingTargets['+447520635886'][] = ['receiver' => '+420776202246'];
        $forwardingTargets['+420234095676'][] = ['receiver' => '+420778001155'];
        $forwardingTargets['+420234095676'][] = ['receiver' => '+420776202246'];

        return $forwardingTargets;
    }
}