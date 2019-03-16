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
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa {{ $icon }}"></i>
                                        </span>
                                        <input placeholder="{{ $label }}" type="{{ $input->type }}" name="{{ $input->name }}" value="{{ $data->{$input->name} }}" class="form-control" @if($input->required) required @endif>
                                    </div>
                                @elseif($input->type == 'select')
                                    <select class="form-control" data-plugin-multiselect name="{{ $input->name }}" @if($input->required) required @endif>
                                        @if(isset($input->default)) <option value="0">{{ $input->default }}</option> @endif
{{--                                        @if(isset($input->selected)) <option value="{{ $input->selected->id }}" selected>{{ $input->selected->plate }} - {{ $input->selected->make }}</option> @endif--}}
                                        @foreach($input->values as $value)
                                            <option value="{{ $value->value }}" @if($data->{$input->name} == $value->value) selected @endif>{{ $value->option }}</option>
                                        @endforeach
                                    </select>
                                @elseif($input->type == 'date')
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input placeholder="{{ $label }}" type="text" name="{{ $input->name }}" data-plugin-datepicker="" value="{{ $data->{$input->name} }}" class="form-control">
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
                                            <label class="col-md-2 control-label">Amount</label>
                                            <input placeholder="0" type="text" name="costs[{{ $cost->id }}][amount]" value="{{ $cost->amount }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-2 control-label">Description</label>
                                            <input placeholder="Input some text..." type="text" name="costs[{{ $cost->id }}][description]" value="{{ $cost->description }}" class="form-control">
                                        </div>
                                        <div class="col-md-1">
                                            {{--<label class="col-md-2 control-label">&nbsp;</label>--}}
                                            <button type="button" class="delete-cost mb-xs mt-xs mr-xs btn btn-danger" data-id="{{ $cost->id }}" style="margin-top: 29px !important;">X</button>
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
                    <label class="col-md-2 control-label">Amount</label>
                    <input placeholder="0" type="text" name="newCosts[costsID][amount]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="col-md-2 control-label">Description</label>
                    <input placeholder="Input some text..." type="text" name="newCosts[costsID][description]" class="form-control">
                </div>
                <div class="col-md-1">
                    {{--<label class="col-md-2 control-label">&nbsp;</label>--}}
                    <button type="button" class="delete-cost mb-xs mt-xs mr-xs btn btn-danger" data-id="costsID" style="margin-top: 29px !important;">X</button>
                </div>
            </div>
        </div>
    @endif
</div>