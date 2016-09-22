<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


return array(
    'user_ask_list' =>
    new Zend_Controller_Router_Route(
            'user/asks/:askid/:userid', array(
        'controller' => 'Ask',
        'action' => 'useraskdetail'
            )
    )
    ,
    'ask_doctor' =>
    new Zend_Controller_Router_Route(
            'ask/doctor/:doctorID', array(
        'controller' => 'Ask',
        'action' => 'goAskDoctor'
            )
    )
    ,
    'detail_blog' =>
    new Zend_Controller_Router_Route(
            'doctor/blog/detail/:uid/:blogid', array(
        'controller' => 'Memberblog',
        'action' => 'detail'
            )
    )
    ,
    'blog' =>
    new Zend_Controller_Router_Route(
            'doctor/blog/:uid/:currentPage', array(
        'controller' => 'Memberblog',
        'action' => 'index'
            )
    )
    ,
    'friends' =>
    new Zend_Controller_Router_Route_Regex(
            'doctor/friends/(\d+)(-)?(\d+)?', array('controller' => 'MemberFriend', 'action' => 'index'), array(
        1 => 'uid',
        3 => 'currentPage'
            )
    )
    ,
    'abstract' =>
    new Zend_Controller_Router_Route(
            'doctor/abstract/:doctorid', array(
        'controller' => 'Doctor',
        'action' => 'doctorAbstract'
            )
    )
    ,
    'goodat' =>
    new Zend_Controller_Router_Route(
            'doctor/goodat/:doctorid', array(
        'controller' => 'Doctor',
        'action' => 'doctorGoodAt'
            )
    )
    ,
    'search' =>
    new Zend_Controller_Router_Route(
            'search/:searchWords/:currentPage', array(
        'controller' => 'Search',
        'action' => 'index'
            )
    )
    ,
    'search_ask' =>
    new Zend_Controller_Router_Route(
            'so/:searchWords/:currentPage', array(
        'controller' => 'Search',
        'action' => 'likedisease'
            )
    )
    ,
    'department_list' =>
    new Zend_Controller_Router_Route(
            'department/list.html', array(
        'controller' => 'Department',
        'action' => 'more'
            )
    )
    ,
    'disease_detail' =>
    new Zend_Controller_Router_Route(
            'disease/:diseaseID', array(
        'controller' => 'Search',
        'action' => 'detaildisease'
            ), array(
        'diseaseID' => '(\d+)\.html'
            )
    )
    ,
    'department_disease' =>
    new Zend_Controller_Router_Route_Regex(
            'classid/(\d+)(-)?(\d*)?.html', // classid-currentPage.html
            array(
        'controller' => 'Department',
        'action' => 'index'
            ), array(
        1 => 'classid',
        3 => 'currentPage'
            )
    )
    ,
    'doctor_list' =>
    new Zend_Controller_Router_Route(
            'doctor', array(
        'controller' => 'Doctor',
        'action' => 'moredoctor'
            )
    )
    ,
    'doctor_personal' =>
    new Zend_Controller_Router_Route(
            'doctor/detail/:uid', array(
        'controller' => 'Doctor',
        'action' => 'index'
            ), array(
        'uid' => '(\d+)\.html'
            )
    )
    ,
    'ask_detail' =>
    new Zend_Controller_Router_Route_Regex(
            'id/(\d+)(-)?(\d+)?.html', array(
        'controller' => 'Ask',
        'action' => 'askdetail'
            ), array(
        1 => 'askid',
        3 => 'classid'
            )
    )
    ,
    'hotwords-sd-list' =>
    new Zend_Controller_Router_Route(
            'hot/sd/:searchWords/:currentPage', array(
        'controller' => 'Hotwords',
        'action' => 'searchword'
            )
    )
    ,
    'hotwords-index' =>
    new Zend_Controller_Router_Route(
            'hot', array(
        'controller' => 'Hotwords',
        'action' => 'index'
            )
    )
    ,
    'search_keywords_list_regex' =>
    new Zend_Controller_Router_Route_Regex('hot/(\w{2,})/?(\d)?', array(
        'controller' => 'hotwords',
        'action' => 'search'
            ), array(
        1 => 'wd',
        2 => 'page'
            )
    )
    ,
    'category_jingyan_regex' =>
    new Zend_Controller_Router_Route_Regex('(expcat|explist|expdis)/(\d+)-?(\d+)?', array(
        'controller' => 'exp',
        'action' => 'category'
            ), array(
        1 => 'cate',
        2 => 'id',
        3 => 'page',
            )
    )
    ,
    'jingyan_index' =>
    new Zend_Controller_Router_Route(
            'jingyan/', array(
        'controller' => 'exp',
        'action' => 'index'
            )
    ),
    'exp_content' =>
    new Zend_Controller_Router_Route_Regex(
            'exp/(\d{10})(\d+).html', array(
        'controller' => 'exp',
        'action' => 'content'
            ), array(
        1 => 'addtime',
        2 => 'id'
            )
    ),
    'exp_share' =>
    new Zend_Controller_Router_Route_Regex(
            'jingyan/shareing/share', array(
        'controller' => 'exp',
        'action' => 'share'
            )
    )
    ,
    'exp_mysharing' =>
    new Zend_Controller_Router_Route_Regex(
            'jingyan/shareing/meshare', array(
        'controller' => 'exp',
        'action' => 'mysharing'
            )
    )
);
