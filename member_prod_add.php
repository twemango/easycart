<?php include_once("include/header.php"); ?>

<div class="row">
  <div class="col-3" style="padding:20px">
    <?php include_once("include/member_menu.php"); ?>
  </div>
  <div class="col-9" style="padding:20px">
    <h5 style="margin-bottom:20px"><b>會員-商品</b></h5>
    
    <form>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">商品名稱</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>

      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">商品類型</legend>
          <div class="col-sm-10">
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
              <label class="form-check-label" for="gridRadios1">
                單一種類
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
              <label class="form-check-label" for="gridRadios2">
                多規格
              </label>
            </div>
          </div>
        </div>
      </fieldset>

      <!-- 商品類型單一種類_start -->
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">售價</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">庫存</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      <!-- 商品類型單一種類_end -->

      <!-- 商品規格多規格_start -->
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">主規格名稱</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">主規格項目</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">副規格名稱</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">副規格項目</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">商品設定</label>
        <div class="col-sm-10">
          
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col-1">顏色</th>
                <th scope="col-1">尺寸</th>
                <th scope="col-md-auto">價格</th>
                <th scope="col-md-auto">庫存</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">紅</th>
                <td>大</td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
              </tr>
              <tr>
                <th scope="row">紅</th>
                <td>中</td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
              </tr>
              <tr>
                <th scope="row">紅</th>
                <td>小</td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
              </tr>

              <tr>
                <th scope="row">綠</th>
                <td>大</td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
              </tr>
              <tr>
                <th scope="row">綠</th>
                <td>中</td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
              </tr>
              <tr>
                <th scope="row">綠</th>
                <td>小</td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
                <td><input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder=""></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>

      <!-- 商品規格多規格_end -->

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">安全庫存量</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
          <small class="form-text text-danger">若庫存是空白, 此項失效</small>
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">開始銷售日期</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="2021-11-19 15:00:00">
        </div>
      </div>
      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">結束銷售日期</label>
        <div class="col-sm-10">
          <input type="ematextil" class="form-control" id="formGroupExampleInput" placeholder="">
        </div>
      </div>

      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">課稅別</legend>
          <div class="col-sm-10">
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios2" id="gridRadios1" value="option1" checked>
              <label class="form-check-label" for="gridRadios1">
                應稅
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios2" id="gridRadios2" value="option2">
              <label class="form-check-label" for="gridRadios2">
                零稅率
              </label>
            </div>
            <div class="form-check-inline">
              <input class="form-check-input" type="radio" name="gridRadios2" id="gridRadios3" value="option3">
              <label class="form-check-label" for="gridRadios3">
                免稅
              </label>
            </div>
          </div>
        </div>
      </fieldset>

      <div class="form-group row">
        <label for="formGroupExampleInput" class="col-sm-2 col-form-label">分類</label>
        <div class="col-sm-10">
          <select class="form-control" id="exampleFormControlSelect1">
            <option>商品分類1</option>
            <option>商品分類2</option>
            <option>商品分類3</option>
            <option>商品分類4</option>
            <option>商品分類5</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">商品圖片</label>
        <div class="col-sm-10">
          <input type="file" class="form-control-file" id="exampleFormControlFile1">
          <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20200%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_17d2cede93b%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_17d2cede93b%22%3E%3Crect%20width%3D%22200%22%20height%3D%22200%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2275.5%22%20y%3D%22104.8%22%3E200x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="figure-img img-fluid rounded" alt="...">
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary" type="button" value="返回" onclick="window.history.back();"></div>
          <div class="col"><input style="margin:20px 0 20px 0" class="btn btn-primary float-right" type="button" value="送出"></div>
        </div>
      </div>
    </form>

  </div>
</div>

<?php include_once("include/footer.php"); ?>