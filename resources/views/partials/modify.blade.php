<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal" action="{{ $action }}" method="post" enctype="multipart/form-data">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">{{ $title }}</h2>
                    <p class="panel-subtitle">
                        {{ $description }}
                    </p>
                </header>
                <div class="panel-body">
                    @foreach($inputs as $label => $input)
                        <div class="form-group">
                            <label class="col-sm-4 control-label">{{ $label }}</label>
                            <div class="col-sm-8">

                                @if($input->type == 'text' or $input->type == 'email')
                                    <?php
                                        if($input->type == 'text')
                                            $icon = 'fa-align-left';
                                        if($input->type == 'email')
                                            $icon = 'fa-envelope';
                                        if(isset($input->number) and $input->number)
                                            $icon = 'fa-sort-numeric-down';
                                        if(isset($input->phone) and $input->phone)
                                            $icon = 'fa-mobile-alt';
                                        if(isset($input->address) and $input->address)
                                            $icon = 'fa-map-marker-alt';
                                        if($input->name == 'name')
                                            $icon = 'fa-signature';
                                        if(isset($input->start_point) and $input->start_point)
                                            $icon = 'fa-hand-point-right';
                                        if(isset($input->end_point) and $input->end_point)
                                            $icon = 'fa-hand-point-left';
                                        if(isset($input->cf) and $input->cf)
                                            $icon = 'fa-vote-yea';
                                        if(isset($input->city) and $input->city)
                                            $icon = 'fa-city';
                                        if(isset($input->country) and $input->country)
                                            $icon = 'fa-globe-europe';
                                        if(isset($input->vat) and $input->vat)
                                            $icon = 'fa-list-ol';
                                        if(isset($input->bank) and $input->bank)
                                            $icon = 'fa-university';
                                        if(isset($input->swift) and $input->swift)
                                            $icon = 'fa-money-check';
                                        if(isset($input->weight_cost) and $input->weight_cost)
                                            $icon = 'fa-weight';
                                        if(isset($input->weight) and $input->weight)
                                            $icon = 'fa-weight-hanging';
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa {{ $icon }}"></i>
                                        </span>
                                        <input placeholder="{{ $label }}" type="{{ $input->type }}" name="{{ $input->name }}" value="{{ $data->{$input->name} }}" @if(isset($input->number)) data-number="number" @endif class="form-control" @if($input->required) required @endif>
                                    </div>
                                @elseif($input->type == 'select')
                                    <div class="input-group btn-group">
                                        <?php
                                        $icon = 'fa-hand-pointer';
                                        if(isset($input->currency) and $input->currency)
                                            $icon = 'fa-coins';
                                        if(isset($input->truck) and $input->truck)
                                            $icon = 'fa-truck';
                                        ?>
                                        <span class="input-group-addon">
                                            <i class="fa {{ $icon }}"></i>
                                        </span>
                                        <select class="form-control" data-plugin-multiselect name="{{ $input->name }}" @if($input->required) required @endif>
                                            @if(isset($input->default)) <option value="0">{{ $input->default }}</option> @endif
                                            @foreach($input->values as $value)
                                                <option value="{{ $value->value }}" @if($data->{$input->name} == $value->value) selected @endif>{{ $value->option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif($input->type == 'multipleSelect')
                                    <div class="input-group btn-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-road"></i>
                                        </span>
                                        <select class="form-control" multiple="multiple" data-plugin-multiselect name="{{ $input->name }}" @if($input->required) required @endif>
                                            @if(isset($input->default)) <option value="0">{{ $input->default }}</option> @endif
                                            @foreach($input->values as $value)
                                                <?php
                                                    $selected = '';
                                                    foreach($input->check as $c) {
                                                        if($c->trip == $c->value) {
                                                            $selected = 'selected';
                                                        }
                                                    }
                                                ?>
                                                <option value="{{ $value->value }}" <?php echo $selected ?>>{{ $value->option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif($input->type == 'date')
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input placeholder="{{ $label }}" type="text" name="{{ $input->name }}" data-datepicker="" @if(!empty($data->{$input->name})) value="{{ date('d M Y', strtotime($data->{$input->name})) }}" @endif class="form-control">
                                    </div>
                                @elseif($input->type == 'file')
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input">
                                                <span class="fileupload-preview"></span>
                                            </div>
                                            <span class="btn btn-default btn-file">
																<span class="fileupload-exists">Change</span>
																<span class="fileupload-new">Select file</span>
																<input type="file">
															</span>
                                            <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @if(isset($costs))
                        <div class="form-group text-center">
                            <button id="addCostsButton" type="button" class="mb-xs mt-xs mr-xs btn btn-primary">
                                <i class="fa fa-plus"></i>
                                Add Cost
                            </button>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Costs</label>
                            <div class="noCostsTitle col-md-6" @if(sizeof($costs) > 0) hidden @endif>
                                <label class="col-md-4 control-label">No Costs</label>
                            </div>
                            <div class="costsList" @if(sizeof($costs) < 1) style="display: none;" @endif>
                                @foreach($costs as $cost)
                                    <div class="costItem" data-id="{{ $cost->id }}">
                                        <label class="costsSeparator col-sm-3 control-label" @if($loop->first) hidden @endif></label>
                                        <div class="col-md-2">
                                            <label class="col-md-2 control-label no-left-padding">Price</label>
                                            <input placeholder="0" type="text" name="costs[{{ $cost->id }}][price]" data-number="number" value="{{ $cost->price }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-md-2 control-label no-left-padding">Description</label>
                                            <input placeholder="Input item description" type="text" name="costs[{{ $cost->id }}][description]" value="{{ $cost->description }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="col-md-2 control-label no-left-padding">Amount</label>
                                            <input placeholder="0" type="text" name="costs[{{ $cost->id }}][amount]" data-number="number" value="{{ $cost->amount }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-1">
                                            {{--<label class="col-md-2 control-label">&nbsp;</label>--}}
                                            <button type="button" class="delete-cost mb-xs mt-xs mr-xs btn btn-danger" data-id="{{ $cost->id }}" data-url="{{ route('ajaxDeleteCost', ['id' => $cost->id]) }}" style="margin-top: 29px !important;">X</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <footer class="panel-footer">
                    <button class="btn btn-primary" type="submit">Submit </button>
                </footer>
            </section>
        </form>
    </div>
    @if(isset($costs))
        <div class="costsListHidden" data-count="{{ $costsLastId }}" hidden>
            <div class="costItem" data-id="costsID">
                <label class="costsSeparator col-sm-3 control-label" hidden></label>
                <div class="col-md-2">
                    <label class="col-md-2 control-label no-left-padding">Price</label>
                    <input placeholder="0" type="text" name="newCosts[costsID][price]" data-number="number" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="col-md-2 control-label no-left-padding">Description</label>
                    <input placeholder="Input item description" type="text" name="newCosts[costsID][description]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="col-md-2 control-label no-left-padding">Amount</label>
                    <input placeholder="0" type="text" name="newCosts[costsID][amount]" data-number="number" value="1" class="form-control" required>
                </div>
                <div class="col-md-1">
                    {{--<label class="col-md-2 control-label">&nbsp;</label>--}}
                    <button type="button" class="delete-cost mb-xs mt-xs mr-xs btn btn-danger" data-id="costsID" data-url="{{ route('ajaxDeleteCost', ['id' => 'costsID']) }}" style="margin-top: 29px !important;">X</button>
                </div>
            </div>
        </div>
    @endif
</div>