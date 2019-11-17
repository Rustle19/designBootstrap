<?php

/**
 * Rest for member
 * @package cont
 * @author russell <russell@simplexi.com.ph>
 * @version  1.0
 * @since  2019.11.15
 */
class contRestTweet extends contBase {
  public function afterInit() {
    $this->setTemplate(null);
    $this->setContentType('json');
  }

  //create tweet
  public function addTweet() {
    //rest/tweet/addTweet?tweetContent=hello
    $iId      = s()->get('sLoginId');
    $sContent = r()->getParam('tweetContent');
    $oModel   = new blTweet(modelTweet::instance());
    $oResult  = $oModel->createTweet(['user_id' => $iId, 'caption' => $sContent]);
    echo json_encode($oResult);
  }
  public function editTweet() {
    //rest/tweet/editTweet?tweetId=1&tweetContent=hello

    $iTweetId = r()->getParam('tweetId');
    $sContent = r()->getParam('tweetContent');
    $oModel   = new blTweet(modelTweet::instance());

    $oResult = $oModel->editTweet(['id' => $iTweetId, 'caption' => $sContent]);
    echo json_encode($oResult);
  }
  public function getTweetList() {
    //rest/tweet/getTweetList
    $oModel  = new blTweet(modelTweet::instance());
    $oResult = $oModel->getTweetList();
    echo json_encode($oResult);
  }

  public function getTweetById() {
    //rest/tweet/getTweetById?tweetId=1
    $iTweetId = r()->getParam('tweetId');
    $oModel   = new blTweet(modelTweet::instance());
    $oResult  = $oModel->getTweetById($iTweetId);
    echo json_encode($oResult);
  }
  public function likeTweet() {
    //rest/tweet/likeTweet?tweetId=1&status=insert
    $iTweetId = r()->getParam('tweetId');
    $sStatus  = r()->getParam('status');
    $oModel   = new blTweet(modelTweet::instance());
    $oResult  = $oModel->likeTweet(['tweet_id' => $iTweetId, 'status' => $sStatus, 'user_id' => s()->get('sLoginId')]);
    echo json_encode($oResult);
  }
  public function getLikeList() {
    //rest/tweet/getLikeList?tweetId=1
    $iTweetId = r()->getParam('tweetId');
    $oModel   = new blTweet(modelTweet::instance());
    $oResult  = $oModel->getLikeList($iTweetId);
    echo json_encode($oResult);
  }
  public function isLiked() {
    //rest/tweet/isLiked?tweetId=1&userId=1
    $iTweetId = r()->getParam('tweetId');
    $iUserId  = r()->getParam('userId');
    $oModel   = new blTweet(modelTweet::instance());
    $oResult  = $oModel->isLiked(['tweet_id' => $iTweetId, 'user_id' => $iUserId]);
    echo json_encode($oResult);
  }
  public function deleteTweet() {
    //rest/tweet/deleteTweet?tweetId=1
    $iTweetId = r()->getParam('tweetId');
    $oModel   = new blTweet(modelTweet::instance());
    $oResult  = $oModel->deleteTweet($iTweetId);
    echo json_encode($oResult);
  }
}
