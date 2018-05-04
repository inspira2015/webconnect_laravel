<!-- start -->
<div class="detailBox">
  <div class="titleBox">
    <label><h2>Comments</h2></label>
    <button type="button" class="close" aria-hidden="true">&times;</button>
  </div>
  <div class="actionBox">
    <ul class="commentList" id="comment_list">
    @foreach ($bailMaterComments as  $key => $item)
      <li id="comment{{$item->id}}">
        <div class="commentText">
          <p >{{$item->comment}}</p>
          <span class="date sub-text">{{ $item->getDateForComment() }}</span>
          <button id="removeButton" data-id="{{$item->id}}"  data-toggle="modal" data-target="#removeComment" class="removeComment btn btn-sm btn-danger">Remove</button>
        </div>
      </li>
    @endforeach
    </ul>
    <form class="form-inline" role="form">
      <div class="form-group">
        <input id="new-comment" data-id="{{$bailMasterId}}" class="form-control" type="text" placeholder="Your comments" />
      </div>
      <div class="form-group">
        <button id="commentButton" class="btn btn-default">Add</button>
      </div>
    </form>
  </div>
</div>
<input type="hidden" id="removeNowRoute" name="removeNowRoute" value="{{ route('removeComment') }}">

<!-- Modal -->
<div class="modal fade" id="removeComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure to remove this comment?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" data-commentid="" id="comment_notworking" class="removeNow btn btn-primary">Remove Comment</button>
      </div>
    </div>
  </div>

</div>
<!-- ends -->