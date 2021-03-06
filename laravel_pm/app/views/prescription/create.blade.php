<form class="create-edit-form form-horizontal" action="<?php echo SR::$baseUrl;?>package/save" method="post">
    <input type="hidden" name="id" value="{{$prescription->id}}">
    <div class="two-column">
        <div class="column first-column">
            <div class="filter-block">
                <div class="form-group">
                    <label class="control-label col-md-4">Category:</label>
                    <div class="col-md-8">
                        <select class="form-control" name="category">
                            <option value="">None</option>
                            @foreach($categories as $key => $category)
                                {{Form::getSelectOption($category, $key, null)}}
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Company:</label>
                    <div class="col-md-8">
                        <select class="form-control" name="company">
                            <option value="">None</option>
                            @foreach($companies as $company)
                                {{Form::getSelectOption($company, $company, null)}}
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Ingredients:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="ingredient">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Brand Name:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="brand_name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-8 col-md-4">
                        <button class="bg-success form-control" type="button">Search</button>
                    </div>
                </div>
            </div>
            <div class="content"></div>

        </div><div class="column last-column">
            <div class="patient-info">
                <div class="col-sm-4">
                    <input class="form-control validate[required]" name="name" type="text" placeholder="Name of Patient" value="{{$prescription->patient_name}}">
                </div>
                <div class="col-sm-6">
                    <input class="form-control validate[required]" name="address" type="text" placeholder="Address" value="{{$prescription->patient_address}}">
                </div>
                <div class="col-sm-2">
                    <input class="form-control validate[required]" name="age" type="text" placeholder="Age" value="{{$prescription->patient_age}}">
                </div>
            </div>
            <div class="content">
                <table class="srui-table-a right-table">
                    <colgroup>
                        <col style="width: 90%"/>
                        <col style="width: 10%"/>
                    </colgroup>
                    <tr>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    @foreach($prescription->items as $item)
                        <tr>
                            <td>
                                <div class="medicine">{{$item->name}}</div>
                                <div class="description"><input class="form-control" name="description" value="{{$item->description}}"></div>
                            </td>
                            <td class="action">
                                <span class="glyphicon glyphicon-remove"></span>
                                <input type="hidden" name="items" value="{{$item->medicine_id}}">
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="custom-medicine">
                <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="Medicine Name">
                </div>
                <div class="col-md-4">
                    <button class="form-control" type="button">Add </button>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-10 col-md-2">
            <button type="submit" class="form-control btn btn-default">Create</button>
        </div>
    </div>
</form>
