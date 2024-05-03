<?php
$connect = mysqli_connect('localhost','root','','book');
if (isset($_POST['them'])) {
    $name = $_POST['name'];
    $query = "select * from product where name='$name'";
    if (mysqli_num_rows($connect->query($query)) != 0) {
        $alert = "Sản phẩm đã tồn tại";
    } else {
        $id_author = $_POST['id_author'];
        $id_cat = $_POST['id_cat'];
        $id_pub = $_POST['id_pub'];
        $cost = $_POST['cost'];
        $price = $_POST['price'];
        $information = $_POST['information'];
        $quantity = $_POST['quantity'];
        $size = $_POST['size'];
        $number_page = $_POST['number_page'];
        // Deal with upload images
        // destination to save images
        $store = "../../image/";
        $imageName1 = $_FILES['image1']['name'];
        // save the temp path of file uploaded 
        $imageTemp1 = $_FILES['image1']['tmp_name'];
        // take the expand of file
        $exp3 = substr($imageName1, strlen($imageName1) - 3); #abcd.jpg;
        $exp4 = substr($imageName1, strlen($imageName1) - 4); #abcd.jpeg;

        $imageName2 = $_FILES['image2']['name'];
        // save the temp path of file uploaded 
        $imageTemp2 = $_FILES['image2']['tmp_name'];
        // take the expand of file
        $exp5 = substr($imageName2, strlen($imageName2) - 3); #abcd.jpg;
        $exp6 = substr($imageName2, strlen($imageName2) - 4); #abcd.jpeg;

        $imageName3 = $_FILES['image3']['name'];
        // save the temp path of file uploaded 
        $imageTemp3 = $_FILES['image3']['tmp_name'];
        // take the expand of file
        $exp7 = substr($imageName3, strlen($imageName3) - 3); #abcd.jpg;
        $exp8 = substr($imageName3, strlen($imageName3) - 4); #abcd.jpeg;
        if (
            ($exp3 == 'jpg' || $exp3 == 'png' || $exp3 == 'bmp' || $exp3 == 'gif' || $exp4 == 'webp' || $exp4 == 'jpeg' ||
            $exp3 == 'JPG' || $exp3 == 'PNG' || $exp3 == 'GIF' || $exp3 == 'BMP' || $exp4 == 'WEBP' || $exp4 == 'JPEG')
            // && (
            //   $exp5 == 'jpg' || $exp5 == 'png' || $exp5 == 'bmp' || $exp5 == 'gif' || $exp6 == 'webp' || $exp6 == 'jpeg' ||
            // $exp5 == 'JPG' || $exp5 == 'PNG' || $exp5 == 'GIF' || $exp5 == 'BMP' || $exp6 == 'WEBP' || $exp6 == 'JPEG'
            // )
            // && (
            //   $exp7 == 'jpg' || $exp7 == 'png' || $exp7 == 'bmp' || $exp7 == 'gif' || $exp8 == 'webp' || $exp8 == 'jpeg' ||
            // $exp7 == 'JPG' || $exp7 == 'PNG' || $exp7 == 'GIF' || $exp7 == 'BMP' || $exp8 == 'WEBP' || $exp8 == 'JPEG'
            // )
        ) {
            // change the name of image, difference 1/1/1970 -> now (ms)
            $imageName1 = time() . '_' . $imageName1;
            $imageName2 = time() . '_' . $imageName2;
            $imageName3 = time() . '_' . $imageName3;
            // move file upload to the destination want to save
            move_uploaded_file($imageTemp1, $store . $imageName1);
            move_uploaded_file($imageTemp2, $store . $imageName2);
            move_uploaded_file($imageTemp3, $store . $imageName3);
            $connect->query("insert into product( id_author,id_pub,id_category,name,cost,price, image1,image2,image3,information, quantity,size,number_page)
            values ( $id_author,$id_pub,$id_cat,'$name',$cost,$price, '$imageName1','$imageName2','$imageName3','$information', $quantity,'$size',$number_page)");
             header("Location:table-data-product.php");
        } else {
          echo "Không thành công";
            $alert = "File đã chọn không hợp lệ";
        }
    }
}
?>
<?php
$author = $connect->query("select * from author");
$category = $connect->query("select * from category");
$pub = $connect->query("select * from publishing_company")
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thêm sản phẩm </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
  <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
</head>

<body class="app sidebar-mini rtl">
  <style>
    .Choicefile {
      display: block;
      background: #14142B;
      border: 1px solid #fff;
      color: #fff;
      width: 150px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      padding: 5px 0px;
      border-radius: 5px;
      font-weight: 500;
      align-items: center;
      justify-content: center;
    }

    .Choicefile:hover {
      text-decoration: none;
      color: white;
    }

    #uploadfile,
    .removeimg {
      display: none;
    }

    #thumbbox {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }

    .removeimg {
      height: 25px;
      position: absolute;
      background-repeat: no-repeat;
      top: 5px;
      left: 5px;
      background-size: 25px;
      width: 25px;
      /* border: 3px solid red; */
      border-radius: 50%;

    }

    .removeimg::before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      content: '';
      border: 1px solid red;
      background: red;
      text-align: center;
      display: block;
      margin-top: 11px;
      transform: rotate(45deg);
    }

    .removeimg::after {
      /* color: #FFF; */
      /* background-color: #DC403B; */
      content: '';
      background: red;
      border: 1px solid red;
      text-align: center;
      display: block;
      transform: rotate(-45deg);
      margin-top: -2px;
    }
  </style>
  <!-- Navbar-->
  <header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
      aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


      <!-- User Menu-->
      <li><a class="app-nav__item" href="/index.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/images/hay.jpg" width="50px"
        alt="User Image">
      <div>
        <p class="app-sidebar__user-name"><b>Võ Trường</b></p>
        <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
      </div>
    </div>
    <hr>
    <ul class="app-menu">
      <li><a class="app-menu__item haha" href="phan-mem-ban-hang.php"><i class='app-menu__icon bx bx-cart-alt'></i>
          <span class="app-menu__label">POS Bán Hàng</span></a></li>
      <li><a class="app-menu__item " href="index.php"><i class='app-menu__icon bx bx-tachometer'></i><span
            class="app-menu__label">Bảng điều khiển</span></a></li>
            <li><a class="app-menu__item " href="table-data-author.php"><i class='app-menu__icon bx bx-id-card'></i> <span
            class="app-menu__label">Quản lý tác giả</span></a></li>
      <li><a class="app-menu__item " href="table-data-customer.php"><i class='app-menu__icon bx bx-user-voice'></i><span
            class="app-menu__label">Quản lý khách hàng</span></a></li>
      <li><a class="app-menu__item active" href="table-data-product.php"><i
            class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Quản lý sách</span></a>
      </li>
      <li><a class="app-menu__item" href="table-data-oder.php"><i class='app-menu__icon bx bx-task'></i><span
            class="app-menu__label">Quản lý đơn hàng</span></a></li>
            <li><a class="app-menu__item" href="table-data-article.php"><i class='app-menu__icon bx bx-run'></i><span
            class="app-menu__label">Quản lý bài viết
          </span></a></li>
      <li><a class="app-menu__item" href="table-data-money.php"><i class='app-menu__icon bx bx-dollar'></i><span
            class="app-menu__label">Bảng kê lương</span></a></li>
      <li><a class="app-menu__item" href="quan-ly-bao-cao.php"><i
            class='app-menu__icon bx bx-pie-chart-alt-2'></i><span class="app-menu__label">Báo cáo doanh thu</span></a>
      </li>
      <li><a class="app-menu__item" href="page-calendar.php"><i class='app-menu__icon bx bx-calendar-check'></i><span
            class="app-menu__label">Lịch công tác </span></a></li>
      <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Cài
            đặt hệ thống</span></a></li>
    </ul>
  </aside>
  <main class="app-content">
    <div class="app-title">
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Danh sách sản phẩm</li>
        <li class="breadcrumb-item"><a href="#">Thêm sản phẩm</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới sản phẩm</h3>
          <div class="tile-body">
            <div class="row element-button">
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i
                    class="fas fa-folder-plus"></i> Thêm tác giả</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i
                    class="fas fa-folder-plus"></i> Thêm thể loại</a>
              </div>
              <div class="col-sm-2">
                <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addtinhtrang"><i
                    class="fas fa-folder-plus"></i> Thêm nhà cung cấp</a>
              </div>
            </div>
            <form class="row" method="post" enctype="multipart/form-data">
              
              <div class="form-group col-md-3">
                <label class="control-label">Tên sản phẩm</label>
                <input class="form-control" type="text" name="name">
              </div>
              <div class="form-group col-md-3 ">
                <label for="exampleSelect1" class="control-label">Tác giả</label>
                <select class="form-control" id="exampleSelect1" name="id_author">
                  <option>-- Chọn tác giả --</option>
                  <?php foreach ($author as $item) : ?>
                <option value="<?= $item['id_author'] ?>" <?= $item['id_author']  ?>>
                    <?= $item['name'] ?>
                </option>
            <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="exampleSelect1" class="control-label">Thể loại</label>
                <select class="form-control" id="exampleSelect1" name="id_cat">
                  <option>-- Chọn thể loại --</option>
                  <?php foreach ($category as $item) : ?>
                <option value="<?= $item['id_category'] ?>" <?= $item['id_category']  ?>>
                    <?= $item['name'] ?>
                </option>
                <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-3 ">
                <label for="exampleSelect1" class="control-label">Nhà cung cấp</label>
                <select class="form-control" id="exampleSelect1" name="id_pub">
                  <option>-- Chọn nhà xuất bản --</option>
                  <?php foreach ($pub as $item) : ?>
                <option value="<?= $item['id_pub'] ?>" <?= $item['id_pub']  ?>>
                    <?= $item['name'] ?>
                </option>
                <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Giá bìa</label>
                <input class="form-control" type="text" name="cost">
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Giá bán</label>
                <input class="form-control" type="text" name="price">
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Ảnh sản phẩm 1</label>
                  <input type="file"  name="image1"  />
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Ảnh sản phẩm 2</label>
                  <input type="file"  name="image2"  />
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Ảnh sản phẩm 3</label>
                  <input type="file"  name="image3"  />
              </div>
              <div class="form-group col-md-12">
                <label class="control-label">Mô tả sản phẩm</label>
                <textarea class="form-control" name="information" id="information"></textarea>
                <script>CKEDITOR.replace('information');</script>
              </div>
              <div class="form-group  col-md-3">
                <label class="control-label">Số lượng</label>
                <input class="form-control" type="number" name="quantity">
              </div>
              <div class="form-group  col-md-3">
                <label class="control-label">Size</label>
                <input class="form-control" type="text" name="size">
              </div>
              <div class="form-group  col-md-3">
                <label class="control-label" type="text">Số trang</label>
                <input class="form-control" name="number_page">
              </div>
          </div>

          <input class="btn btn-save" type="submit" name="them" value="Lưu lại"></input>
          <a class="btn btn-cancel" href="table-data-product.php">Hủy bỏ</a>
        </div>
                  </form>
  </main>


  <!--
  MODAL CHỨC VỤ 
-->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới nhà cung cấp</h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tên chức vụ mới</label>
              <input class="form-control" type="text" required>
            </div>
          </div>
          <BR>
          <input class="btn btn-save" type="submit" name="them" >Lưu lại</input>
          <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
          <BR>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--
MODAL
-->



  <!--
  MODAL DANH MỤC
-->
  <div class="modal fade" id="adddanhmuc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới danh mục </h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tên danh mục mới</label>
              <input class="form-control" type="text" required>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Danh mục sản phẩm hiện đang có</label>
              <ul style="padding-left: 20px;">
                <li>Bàn ăn</li>
              <li>Bàn thông minh</li>
              <li>Tủ</li>
              <li>Ghế gỗ</li>
              <li>Ghế sắt</li>
              <li>Giường người lớn</li>
              <li>Giường trẻ em</li>
              <li>Bàn trang điểm</li>
              <li>Giá đỡ</li>
              </ul>
            </div>
          </div>
          <BR>
          <button class="btn btn-save" type="button">Lưu lại</button>
          <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
          <BR>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--
MODAL
-->




  <!--
  MODAL TÌNH TRẠNG
-->
  <div class="modal fade" id="addtinhtrang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">
          <div class="row">
            <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới tình trạng</h5>
              </span>
            </div>
            <div class="form-group col-md-12">
              <label class="control-label">Nhập tình trạng mới</label>
              <input class="form-control" type="text" required>
            </div>
          </div>
          <BR>
          <button class="btn btn-save" type="button">Lưu lại</button>
          <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
          <BR>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!--
MODAL
-->



  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  <script src="js/plugins/pace.min.js"></script>
  <script>
    const inpFile = document.getElementById("inpFile");
    const loadFile = document.getElementById("loadFile");
    const previewContainer = document.getElementById("imagePreview");
    const previewContainer = document.getElementById("imagePreview");
    const previewImage = previewContainer.querySelector(".image-preview__image");
    const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");
    inpFile.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        previewDefaultText.style.display = "none";
        previewImage.style.display = "block";
        reader.addEventListener("load", function () {
          previewImage.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
      }
    });

  </script>
</body>

</html>