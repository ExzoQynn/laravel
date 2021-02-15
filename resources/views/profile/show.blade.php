@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- profile -->
        <div class="col-md-3 mb-3">
            <div class="card bg-black" style="width: 100%;">
                <div class="card-body text-center text-white">
                    <img src="{{asset('/storage/profile/'.$data->profile_image)}}" class="rounded-circle " alt="" width="120" height="120">

                </div>
                <div class="card-body text-center text-white">
                    <h5 class="card-title">{{$data->name}} <a href="{{route('profile.edit' , $data->id)}}" class="btn btn-outline-primary " style="padding:0rem .8rem;" data-bs-toggle="modal" data-bs-target="#EditProfile"><i class="fas fa-edit"></i></a> </h5>
                </div>
            </div>
        </div>


        <!-- Post -->
        <div class="col-md-9">
            <div class="card bg-black mb-3" style="width: 100%;">
                <div class="card-body row col-md-12">
                    <div class="col" style="flex: 0 0 0% !important;padding-right:0;">
                        <img src="{{asset('/storage/profile/'.$data->profile_image)}}" class="rounded-circle mt-1" alt="" width="30" height="30">
                    </div>
                    <div class="col" style="padding-right:0;">
                        <input type="text" class="form-control bg-black-input" placeholder="Create post" readonly data-bs-toggle="modal" data-bs-target="#CreatePost" value="{{old('text_post')}}">
                    </div>

                </div>
            </div>

            @foreach($data_post as $row)
            <!-- Start Post -->
            <div class="card bg-black-post mb-3" style="width: 100%;">
                <!-- Header Post -->
                <div class="card-body row col-md-12">
                    <div class="col" style="flex: 0 0 0% !important;padding-right:0;">
                        <img src="{{asset('/storage/profile/'.$data->profile_image)}}" class="rounded-circle mt-1" alt="" width="30" height="30">
                    </div>
                    <div class="col" style="padding-right:0;">
                        <b>{{$data->name}}</b>
                    </div>
                    <div class="col text-right" style="padding-right:0;">

                        <button type="button" class="btn btn-black-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h" style="margin-left:-1px;"></i></button>
                        <div class="dropdown-menu dropdown-menu-right bg-dropdown-back">
                            <a class="dropdown-item dropdown-item-back" data-bs-toggle="modal" data-bs-target="#EditPost" onClick="OpenEditPost('{{$row->id}}')">Edit post</a>
                            <a class="dropdown-item dropdown-item-back" href="#">Edit status post</a>
                            <div class="dropdown-divider" style="border-top:1px solid rgb(176 179 184) !important;"></div>
                            <form action=" {{route('post.destroy' , $row->id)}} " method="POST">
                            @csrf @method('DELETE')
                                <button class="dropdown-item dropdown-item-back" type="submit">Delete post</button>
                            </form>
                        </div>

                    </div>
                </div>

                <!-- Detail Post -->
                <div class="card-body row col-md-12 pt-0" style="border-bottom: 0px;">
                    <div class="col-12" style="padding-right:0;">
                        <p>{{$row->description}}</p>
                    </div>
                    <div class="col-md-12 ms-3 ps-0 text-gray text-right" style="border-bottom: 1px solid;">
                        ?? Comment
                    </div>
                </div>


                <!-- Footer Post -->
                <div class="card-body pt-0 row col-md-12 ">
                    <div class="col" style="flex: 0 0 0% !important;padding-right:0;">
                        <img src="{{asset('/storage/profile/'.$data->profile_image)}}" class="rounded-circle mt-1" alt="" width="30" height="30">
                    </div>
                    <div class="col" style="padding-right:0;">
                        <input type="text" class="form-control bg-black-input" placeholder="Comment ......" name="comment{{$row->id}}" id="comment{{$row->id}}">
                    </div>
                </div>
            </div>

            @endforeach
        </div>


    </div>
</div>


<!-- Modal Edit Post -->
<div class="modal fade" id="EditPost" tabindex="-1" aria-labelledby="EditPostModal" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered  modal-lg  ">
        <div class="modal-content bg-black">
            <form action="{{route('post.store' , $data->id)}}" method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="border-bottom:1px solid #3a3b3c;">
                    <h5 class="modal-title" id="EditPostModal">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    {{$data_edit}}
                    <input type="text" name="edit_user_id" id="edit_user_id" value="{{$data->id}}" hidden>
                    <input type="text" name="edit_status_post" id="edit_status_post" value="1" hidden>
                    <textarea name="edit_description" id="edit_description" cols="30" rows="10" class="form-control bg-black-text-area" style="resize:none"></textarea>
                    <div class="card bg-black-border-white" style="width: 100%;">
                        <div class="card-body row col-md-12" style="padding-right: 0;">
                            <div class="col-6">
                                Add it to your post
                            </div>
                            <div class="col-6 text-right" style="padding-right: 0;">
                                <i class="far fa-images " style="color:#3e9f56;font-size:15pt"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="border-top:1px solid #3a3b3c;">
                    <button type="submit" class="btn btn-outline-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Create Post -->
<div class="modal fade" id="CreatePost" tabindex="-1" aria-labelledby="CreatePostModal" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered  modal-lg  ">
        <div class="modal-content bg-black">
            <form action="{{route('post.store' , $data->id)}}" method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="border-bottom:1px solid #3a3b3c;">
                    <h5 class="modal-title" id="CreatePostModal">Create Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="text" name="user_id" id="user_id" value="{{$data->id}}" hidden>
                    <input type="text" name="status_post" id="status_post" value="1" hidden>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control bg-black-text-area" style="resize:none"></textarea>
                    <div class="card bg-black-border-white" style="width: 100%;">
                        <div class="card-body row col-md-12" style="padding-right: 0;">
                            <div class="col-6">
                                Add it to your post
                            </div>
                            <div class="col-6 text-right" style="padding-right: 0;">
                                <i class="far fa-images " style="color:#3e9f56;font-size:15pt"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="border-top:1px solid #3a3b3c;">
                    <button type="submit" class="btn btn-outline-success">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Edit Profile -->
<div class="modal fade" id="EditProfile" tabindex="-1" aria-labelledby="EditProfileModal" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered  modal-lg  ">
        <div class="modal-content ">
            <form action="{{route('profile.update' , $data->id )}}" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditProfileModal">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="profile">Peofile</label>
                        <input type="file" class="form-control" name="profile_image" id="profile_image" value="{{old('profile_image',$data->profile_image)}}">
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{old('name' , $data->name)}}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{old('email' , $data->email)}}">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea type="text" class="form-control" name="address" id="address" placeholder="Address">{{old('address' ,$data->address)}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="tel">Tel</label>
                        <input type="text" class="form-control" name="tel" id="tel" placeholder="Tel" value="{{old('tel' ,$data->tel )}}">
                    </div>

                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="text" class="form-control datepicker" name="birth_day" id="birth_day" placeholder="Birthday" data-provide="datepicker" data-date-language="th-th" data-date-format="dd/mm/yyyy" value="{{old('birth_day' , date('d/m/Y', strtotime($data->birth_day)) )}}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function OpenEditPost(post_id) {

    }
</script>


@endsection