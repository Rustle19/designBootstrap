<?php

/**
 * modelTweet
 * @package model
 * @author  russell <russell@simplexi.com.ph>
 * @version  1.0
 * @since 2019.11.05
 */
class modelTweet extends modelCommon {

  /**
   * instance
   * @return object model instance
   */
  public static function instance() {
    return parent::_load(__CLASS__);
  }

  /**
   * @param array $aParams array('user_id' => 'user id here','caption' => 'caption here')
   * @return integer id
   * @throws exceptionActiverecord
   */
  public function addTweet($aParams) {
    $aData  = ['user_id' => $aParams['user_id'], 'caption' => $aParams['caption']];
    $sQuery = $this->helper->insert('t_tweet', $aData);
    $this->query($sQuery);
    $iId = $this->lastInsertId();

    return $iId;
  }
  /**
   * @param $aParams
   */
  public function editTweet($aParams) {
    $aData = ['caption' => $aParams['caption']];
    $this->helper->where('id', $aParams['id']);
    $sQuery = $this->helper->update('t_tweet', $aData);
    $this->query($sQuery);
  }
  /**
   * @param $iTweetId
   */
  public function deleteTweet($iTweetId) {
    $sQuery = $this->helper->delete('t_tweet', ['id' => $iTweetId]);
    $this->query($sQuery);

  }
  /**
   * @param $iTweetId
   */
  public function likeTweet($aParams) {
    $sQuery = $this->helper->{$aParams['status']}('t_like', ['tweet_id' => $aParams['tweet_id'], 'user_id' => $aParams['user_id']]);
    $this->query($sQuery);
  }
  /**
   * @param $iTweetId
   */
  public function isLiked($aParams) {
    $this->helper->select('*');
    $this->helper->from('t_like');
    $this->helper->where('tweet_id', $aParams['tweet_id'], 'user_id', $aParams['user_id']);
    $this->helper->where('user_id', $aParams['user_id']);
    $sQuery = $this->helper->get();

    return $this->query($sQuery, FW_MODEL_RESULT_ROW);
  }
  /**
   * @param $iTweetId
   * @return mixed
   */
  public function getTweetById($iTweetId) {

    $this->helper->select('t_tweet.id, t_tweet.caption, t_user.name, t_user.username, t_tweet.created_at, t_user.image');
    $this->helper->from('t_tweet');
    $this->helper->join('t_user', 't_tweet.user_id = t_user.id');
    $this->helper->where('t_tweet.id', $iTweetId);
    $this->helper->order_by('t_tweet.created_at', 'desc');
    $sQuery = $this->helper->get();

    return $this->query($sQuery, FW_MODEL_RESULT_ROW);
  }

  /**
   * @return mixed
   */
  public function getTweetList() {

    $this->helper->select('t_tweet.id, t_tweet.caption,t_tweet.user_id, t_user.name, t_user.username, t_tweet.created_at, t_user.image');
    $this->helper->from('t_tweet');
    $this->helper->join('t_user', 't_tweet.user_id = t_user.id');
    $this->helper->order_by('t_tweet.created_at', 'desc');

    $sQuery = $this->helper->get();

    return $this->query($sQuery, FW_MODEL_RESULT_ROWS);
  }
  /**
   * @param $iTweetId
   * @return mixed
   */
  public function getLikeList($iTweetId) {

    $this->helper->select('*');
    $this->helper->from('t_like');
    $this->helper->where('tweet_id', $iTweetId);

    $sQuery = $this->helper->get();
    return $this->query($sQuery, FW_MODEL_RESULT_ROWS);
  }
}