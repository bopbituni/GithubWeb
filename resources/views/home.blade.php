@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong> {{Session::get('success')}}</strong>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header" style="
                font-weight: bold;
                font-size: 30px;
                text-align: center">
                        Thông tin User
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$user->avatar}}" style="width: 90px; height: 90px; border-radius: 90px">
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4" style="font-size: 18px">Tên người dùng :</div>
                                    <div class="col-md-8" style="font-size: 18px"> {{$user->name}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4" style="font-size: 18px">Địa chỉ email :</div>
                                    <div class="col-md-8" style="font-size: 18px"> {{$user->email}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4" style="font-size: 18px">Ngày tạo tài khoản :</div>
                                    <div class="col-md-8"
                                         style="font-size: 18px"> {{date('d-m-y', strtotime($user->created_at))}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 offset-md-2" style="font-size: 18px">
                                        <a href="{{route('display-clone')}}">Repositories Clone của tôi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px">
                <div class="card">
                    <div class="card-header" style="
                font-weight: bold;
                font-size: 30px;
                text-align: center">
                        Danh sách Repositories
                    </div>
                    <div class="card-body row">
                        <form class="col-md-8 offset-md-2">
                            @csrf
                            <div class="input-group mb-3" style="">
                                <input type="text" class="form-control" id="input"
                                       placeholder="Hãy nhập tên của bạn vào đây ..."
                                       aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" type="button" id="button-success">Xác
                                        nhận
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-10 offset-md-1"
                             style=" border-bottom: black solid 2px; margin-top: 20px; margin-bottom: 20px">
                        </div>
                        <div class="col-md-10 offset-md-1" id="response">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-danger" style="width: 5rem; height: 5rem;" role="status">
                    <div>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>

    $(document).ready(function () {
        $('#button-success').on('click', function (e) {
            // start modal
            showModalLoading();

            let html = ""; // hiển thị
            let inputValue = $('#input').val(); // tên chủ sở hưu các repos
            let page = 1; //số page
            let resArray = []; //mảng
            let resLength = 0; //số lượng repos được load hiện tại
            let indexMax = 0; // số lượng repos max sau mỗi lần click load more
            $.ajax({
                url: "https://api.github.com/users/" + inputValue,
                type: "GET",
                async: false,
                success: function (response) {
                    //Hiển thị tổng số repos của một user
                    html = ""
                    html += "<div class='row' style='margin-bottom: 10px'>"
                    html += "<div class='col-md-4'>"
                    html += "Public Repositories : " + response.public_repos
                    html += "</div>"
                    $('#response').html(html)

                    //Hàm hiển thị repos tách ra cho dễ xử lý
                    function displayRepos(page = 1, isDisplay, callback) {
                        $.ajax({
                            url: "https://api.github.com/users/" + inputValue + "/repos?page=" + page,
                            type: "GET",
                            // async: false,
                            success: function (res) {
                                resLength += res.length
                                html += "<div class='col-md-8'>"
                                html += "Current Repositories : " + resLength
                                html += "</div>"
                                html += "</div>"
                                // Gán lại giá trị các phần tử của mảng res vào mảng mới để dễ kiểm soát số lượng repos đang có
                                $.each(res, function (index, value) {
                                    resArray.push(value)
                                })
                                $.each(resArray, function (index, value) {
                                    //Hàm hiển thị ra giao diện
                                    function displayHtml() {
                                        html += "<div class='card' style='margin-bottom: 15px'>"
                                        html += "<div class='row' style='padding: 10px'>"
                                        html += "<div class='col-md-3'>"
                                        html += "Number :"
                                        html += "</div>"
                                        html += "<div class='col-md-9'>"
                                        html += index + 1
                                        html += "</div>"
                                        html += "<div class='col-md-3'>"
                                        html += "Name :"
                                        html += "</div>"
                                        html += "<div class='col-md-9'>"
                                        html += value.name + " - ( " + value.stargazers_count + "* )"
                                        html += "</div>"
                                        html += "<div class='col-md-3'>"
                                        html += "Full name :"
                                        html += "</div>"
                                        html += "<div class='col-md-9'>"
                                        html += value.full_name
                                        html += "</div>"
                                        html += "<div class='col-md-3'>"
                                        html += "Link Url :"
                                        html += "</div>"
                                        html += "<div class='col-md-9'>"
                                        html += value.html_url
                                        html += "</div>"
                                        html += "<div class='col-md-3'>"
                                        html += "Fork :"
                                        html += "</div>"
                                        html += "<div class='col-md-9'>"
                                        html += value.fork
                                        html += "</div>"
                                        html += "<div class='col-md-3'>"
                                        html += "Create At :"
                                        html += "</div>"
                                        html += "<div class='col-md-9'>"
                                        html += value.created_at
                                        html += "</div>"
                                        html += "</div>"
                                        html += "<form method='POST' action=\"{{route('set-repository')}}\" class='col-md-2 offset-md-5'>"
                                        html += '@csrf'
                                        html += '<input name="name" value="' + value.name + '" type="hidden">'
                                        html += '<input name="fullName" value="' + value.full_name + '" type="hidden">'
                                        html += '<input name="link_url" value="' + value.html_url + '" type="hidden">'
                                        html += '<input name="fork" value="' + value.fork + '" type="hidden">'
                                        html += '<input name="repo_id" value="' + value.id + '" type="hidden">'
                                        html += '<input name="date" value="' + value.created_at + '" type="hidden">'
                                        if (!checkRepo().includes(value.name)) {
                                            html += "<Button class='btn btn-primary' style='width: 150px; margin-bottom: 10px'>Clone</Button>"
                                        }
                                        html += "</form>"
                                        html += "</div>"
                                        return html;
                                    }

                                    // Hiện thị lần tìm kiếm thứ nhất
                                    if (isDisplay) {
                                        displayHtml()
                                    } else {
                                        //Sau khi click load more hiện thị các index tiếp theo thay vì hiển thị lại từ đầu
                                        if (index >= indexMax) {
                                            displayHtml();
                                        }
                                    }
                                });

                                if (response.public_repos > resLength) {
                                    html += "<div>"
                                    html += "<Button class='btn btn-link' id='load_more'>Load more</Button>"
                                    html += "</div>"
                                }
                                var promise = new Promise(
                                    function (resolve, reject) {
                                        resolve($('#response').html(html))
                                    }
                                )
                                promise.then($('#edit-modal').modal("hide"))
                                callback();
                            },

                            error: function (e) {
                                alert('Không tìm thấy thông tin người dùng')
                                html = "Không có dữ liệu"
                                $('#response').html(html);
                                setTimeout(function () {
                                    $('#edit-modal').modal("hide")
                                }, 1000)                            },
                            // complete: function () {
                            //     $('#edit-modal').modal("hide")
                            // },
                        });
                    }

                    // Hiện thị giao diện
                    displayRepos(page, true)

                    // Xử lý sự kiện load thêm dữ liệu nếu có nhiều hơn 30 repos
                    $(document).on('click', '#load_more', function () {
                        // start modal
                        showModalLoading();
                        displayRepos(++page, false, remove)
                        indexMax += 30;
                        var promise = new Promise(
                            function (resolve, reject) {
                                resolve($('#response').append(html))
                            }
                        )
                        promise.then(
                            setTimeout(function () {
                                $('#edit-modal').modal("hide")
                            }, 2000)
                        )
                    });

                    //Hàm này để xử lý callback và xóa button loadmore
                    function remove() {
                        $('#load_more').remove();
                    }
                },
                error: function (e) {
                    html = "Không có dữ liệu"
                    $('#response').html(html)
                    setTimeout(function () {
                        $('#edit-modal').modal("hide")
                    }, 1000)
                },
            });
        })

        // Hàm gọi dữ liệu các repo trong DB
        function checkRepo() {
            let arrayReposDisplay = []; //mảng các repo đã lưu trong db
            $.ajax({
                async: false,
                url: "{{route('get-repository')}}",
                method: 'GET',
                success: function (res) {
                    if (res.errorCode == 0) {
                        $.each(res.data, function (index, value) {
                            arrayReposDisplay.push(value.name)
                        })
                    } else {
                        alert(res.message)
                    }
                },
                error: function (e) {
                    console.log(e)
                }
            })
            return arrayReposDisplay;
        }
    })

    function showModalLoading() {
        var options = {
            'backdrop': 'static',
            keyboard: false
        };
        $('#edit-modal').modal(options)
    }
</script>
