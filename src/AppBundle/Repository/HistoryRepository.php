<?php
/**
 * Created by PhpStorm.
 * User: �������
 * Date: 29.01.2017
 * Time: 18:29
 */

namespace AppBundle\Repository;


use AppBundle\Entity\History;

class HistoryRepository  extends \Doctrine\ORM\EntityRepository
{
    public function getStatByDate($history){
        $clicksStat = array();
        /** @var History $data */
        foreach($history as $data){
            $index = $data->getCreatedAt()->format('Y-m-d H:00:00');
            if(!isset($clicksStat[$index])){
                $clicksStat[$index] = 1;
            }else{
                $clicksStat[$index]++;
            }
        }
        return $clicksStat;
    }

    public function getStatByAgent($history){
        $clicksStat = array();
        /** @var History $data */
        foreach($history as $data){
            $index = $data->getBrowsers();
            if(!isset($clicksStat[$index])){
                $clicksStat[$index] = 1;
            }else{
                $clicksStat[$index]++;
            }
        }
        return $clicksStat;
    }

    public function getStatByReferrers($history){
        $clicksStat = array();
        /** @var History $data */
        foreach($history as $data){
            $index = $data->getReferrers();
            if(empty($index)){
                $index = 'неизвестен';
            }
            if(!isset($clicksStat[$index])){
                $clicksStat[$index] = 1;
            }else{
                $clicksStat[$index]++;
            }
        }
        return $clicksStat;
    }

    public function getStatByIp($history){
        $clicksStat = array();
        /** @var History $data */
        foreach($history as $data){
            $index = $data->getIp();
            if(!isset($clicksStat[$index])){
                $clicksStat[$index] = 1;
            }else{
                $clicksStat[$index]++;
            }
        }
        return $clicksStat;
    }

}