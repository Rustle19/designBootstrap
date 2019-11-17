<?php

/**
 * blTweet
 * @package bl
 * @author russell <russell@simplexi.com.ph>
 * @version  1.0
 * @since  2019.11.15
 */
class blTweet extends blBase {
  /**
   * tweet model instance
   * @var object
   */
  private $oTweetModel;

  /**
   * __construct
   * @param object $oTodoModel
   */
  public function __construct($oTodoModel) {
    $this->oTweetModel = $oTodoModel;
  }

  /**
   * @param $aTweet
   */
  public function createTweet($aTweet) {
    $iTweetId   = $this->oTweetModel->addTweet($aTweet);
    $aTweetInfo = $this->getTweetById($iTweetId);

    return ['bResult' => true, 'aTweetInfo' => $aTweetInfo];
  }
  /**
   * @param $aTweet
   */
  public function editTweet($aTweet) {
    $this->oTweetModel->editTweet($aTweet);
    $aTweetInfo = $this->getTweetById($aTweet['id']);

    return ['bResult' => true, 'aTweetInfo' => $aTweetInfo];
  }

  /**
   * @param $iTweetId
   */
  public function getTweetById($iTweetId) {
    $aTweet = $this->oTweetModel->getTweetById($iTweetId);

    return ['bResult' => true, 'aTweet' => $aTweet];
  }

  public function getTweetList() {
    $tweets = $this->oTweetModel->getTweetList();

    return ['bResult' => true, 'aTweets' => $tweets, 'sLoggedInId' => s()->get('sLoginId')];
  }
  /**
   * @param $iTweetId
   */
  public function likeTweet($aTweet) {
    $this->oTweetModel->likeTweet($aTweet);
    return ['bResult' => true];
  }
  /**
   * @param $aTweet
   */
  public function isLiked($aTweet) {
    $bResult = $this->oTweetModel->isLiked($aTweet);
    return ['aResult' => $bResult];
  }
  /**
   * @param $iTweeId
   */
  public function getLikeList($iTweetId) {

    $aResult = $this->oTweetModel->getLikeList($iTweetId);
    return ['aResult' => $aResult];
  }
  /**
   * @param $iTweetId
   */
  public function deleteTweet($iTweetId) {
    $this->oTweetModel->deleteTweet($iTweetId);

    return ['bResult' => true];
  }

}
