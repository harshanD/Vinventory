<?php
?>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?= $data['name']?></h4>
        </div>
        <div id="edit_model_messages"></div>


        <div class="row justify-content-between">
            <div class="col-6 col-md-4" style="align:right">
                <a class="image-link-custom"><img
                            src="<?= asset('storage/' . $data['image']) ?>"
                            style="width:150px;height:150px;border:1px solid black;margin-left: 3px"
                            alt="placeholder avatar"></a>
            </div>
            <div class="col-12 col-sm-6 col-md-8">
                {{--                <div class="float-right" style="margin-left: 200px">--}}
                <table class="table">
                    <tr>
                        <td style="width: 100px;text-align: right">Name</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['name'] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Code</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['code'] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Brand</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['brand'] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Category</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['category'] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Cost (Rs)</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= number_format($data['cost'], 2)?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Price (Rs)</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= number_format($data['price'], 2)?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Tax Rate</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['taxRate'] . " %"?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Tax Method</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['taxMethod'] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100px;text-align: right">Alert Quantity</td>
                        <td width="20px"></td>
                        <td style="font-weight: bold"><?= $data['alertQty'] ?></td>
                    </tr>
                </table>
                {{--                </div>--}}
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-sm-9" align="center">
                <h4 style="text-align: center"><u>Warehouse Quantity</u></h4>
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th>Warehouse Name</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tboody>
                        @foreach($data['warehouses'] as $ware)
                            <tr>
                                <td><?= $ware['name']?></td>
                                <td style="text-align: right"><?= number_format($ware['qty'], 0)?></td>
                            </tr>
                        @endforeach
                    </tboody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

