<?php include_once("include/header.php"); ?>
<div style="padding:20px">
    <form>
    <table class="table">
    <thead class="thead-light">
        <tr>
        <th scope="col">#</th>
        <th scope="col">商品名稱</th>
        <th scope="col">規格</th>
        <th scope="col">數量</th>
        <th scope="col">金額</th>
        <th scope="col">刪除</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>pro1</td>
            <td></td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
            </td>
            <td>1000</td>
            <td>
                <input class="btn btn-primary" type="button" value="刪除">
            </td>
        </tr>

        <tr>
            <th scope="row">2</th>
            <td>pro2</td>
            <td>顏色: 紅</td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
            </td>
            <td>1000</td>
            <td>
                <input class="btn btn-primary" type="button" value="刪除">
            </td>
        </tr>

        <tr>
            <th scope="row">3</th>
            <td>pro3</td>
            <td>顏色: 紅<br>尺寸: 大</td>
            <td>
                <div class="form-group">
                    <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
            </td>
            <td>1000</td>
            <td>
                <input class="btn btn-primary" type="button" value="刪除">
            </td>
        </tr>

    </tbody>
    </table>

    <div>訂單總額: $8000</div>

    <button style="margin:20px 0 20px 0" type="submit" class="btn btn-primary">結帳</button>
    </form>
</div>

<?php include_once("include/footer.php"); ?>