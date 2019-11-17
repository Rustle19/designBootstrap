<div class="col-6">
    <div class="card w-100 ml-0 p-4 shadow mb-2">
      <div class="mb-0">
        <form id="addTweet">
          <textarea
            class="form-control tweet"
            name="tweetContent"
            placeholder="What's on your mind?"
            rows="4"
            id="tweet_content"
          ></textarea>
          <div class="d-flex justify-content-between">
            <p class="invalid-feedback form-text error_msg"></p>
            <p id="counter" style="font-size:13px"></p>
          </div>
          <div class="mt-2">
            <button
              type="submit"
              id="btnPost"
              class="btn btn-outline-dark float-right"
              style="border-radius: 25px"
            >
              Tweet
            </button>
          </div>
        </form>
      </div>
    </div>
    <div class="card w-100 ml-0 p-4 shadow mb-2">
      <div id="tweets"></div>
      <div class="modal fade" id="likesModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title ">Loved by</h5>
                <button type="button" class="close" data-dismiss="modal">
                  <span>&times;</span>
                </button>
              </div>
              <div class="modal-body d-flex">
                  <div>
                    <img class="text-center" src="/img/default-avatar.jpg" height="60px" />
                  </div>
                  <div class="text-center">
                <a href="/profile"  style='line-height:3;font-size:18px;margin-left:10px'>Russell John Santos</a>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form id="editTweet">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Tweet</h5>
                <button type="button" class="close" data-dismiss="modal">
                  <span>&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <input type="hidden" id="edit_tweet_id" name="tweetId" />
                  <textarea
                    type="text"
                    class="form-control"
                    id="edit_tweet_content"
                    name="tweetContent"
                    placeholder="Edit Tweet"
                    autocomplete="off"
                  ></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancel" data-dismiss="modal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-dark" id="btnUpdateTweet">Update Tweet</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

