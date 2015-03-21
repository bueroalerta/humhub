<?php

/**
 * ProfileController is responsible for all user profiles.
 * Also the following functions are implemented here.
 *
 * @author Luke
 * @package humhub.modules_core.user.controllers
 * @since 0.5
 */
class ProfileController extends ContentContainerController
{

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@', (HSetting::Get('allowGuestAccess', 'authentication_internal')) ? "?" : "@"),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     *
     */
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest && $this->getUser()->visibility == User::VISIBILITY_REGISTERED_ONLY) {
            return $this->render('members_only', array('user' => $this->getUser()));
        }

        $this->render('index');
    }

    /**
     *
     */
    public function actionAbout()
    {
        if (Yii::app()->user->isGuest && $this->getUser()->visibility == User::VISIBILITY_REGISTERED_ONLY) {
            return $this->render('members_only', array('user' => $this->getUser()));
        }

        $this->render('about', array('user' => $this->getUser()));
    }

    /**
     * Unfollows a User
     *
     */
    public function actionFollow()
    {
        $this->forcePostRequest();
        $this->getUser()->follow();
        $this->redirect($this->getUser()->getUrl());
    }

    /**
     * Unfollows a User
     */
    public function actionUnfollow()
    {
        $this->forcePostRequest();
        $this->getUser()->unfollow();
        $this->redirect($this->getUser()->getUrl());
    }

}

?>
