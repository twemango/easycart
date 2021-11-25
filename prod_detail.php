<?php include_once("include/header.php"); ?>

<div class="row shadow">
    <div class="col-4 card-body">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">商品列表</h6>
            </div>

            <ul class="list-group">
                <li class="list-group-item active">商品列表1</li>
                <li class="list-group-item">商品列表2</li>
                <li class="list-group-item">商品列表3</li>
            </ul>
        </div>
    
    </div>
    <div class="col-8 card-body">
 
        <div>
            <img <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20200%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17d2cede93b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17d2cede93b%22%3E%3Crect%20width%3D%22200%22%20height%3D%22200%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2275.5%22%20y%3D%22104.8%22%3E200x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="..." class="img-thumbnail">
        </div>
        <div class="col-3 card-body"></div>

        <!-- 商品名稱 -->
        <h2>商品名稱</h2>
        <!-- 商品價格 -->
        <h3>NT$1200</h3>
        <form>    
        <!-- 商品規格_start -->
        <div class="form-group row">
            <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">顏色</label>
            <div class="col-sm-10">
                <select class="form-control" id="exampleFormControlSelect1">
                    <option value="op" selected>紅</option>
                    <option value="op">綠</option>
                    <option value="op">藍</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="exampleFormControlSelect2" class="col-sm-2 col-form-label">尺寸</label>
            <div class="col-sm-10">
                <select class="form-control" id="exampleFormControlSelect2">
                    <option value="op" selected>大</option>
                    <option value="op">中</option>
                    <option value="op">小</option>
                </select>
            </div>
        </div>
        <!-- 商品規格_end -->

        <!-- 購買數量_start -->
        <div class="form-group row">
            <label for="exampleFormControlSelect3" class="col-sm-2 col-form-label">購買數量</label>
            <div class="col-sm-10">
                <select class="form-control" id="exampleFormControlSelect3">
                    <option value="op" selected>1</option>
                    <option value="op">2</option>
                    <option value="op">3</option>
                </select>
            </div>
        </div>
        <!-- 購買數量_end -->

        <button style="margin-top:20px" type="submit" class="btn btn-primary">購買</button>
        </form>

    </div>
</div>

<?php include_once("include/footer.php"); ?>