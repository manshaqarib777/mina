<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td>{{$_SESSION['i']}}</td>
        <td>{{$dash}}{{$subcategory->name}}</td>
        <td>{{$subcategory->slug}}</td>
        <td>
            @if(isset($subcategory->parentCategory))
                {{$subcategory->parentCategory->name}}
            @else
                None
            @endif
        </td>
        <td class="text-center hidden-print">
            <div class="btn-group">
                <button type="button"
                    class="btn btn-default">{{ trans('file.Action') }}</button>
                <button type="button" class="btn btn-default dropdown-toggle"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                    <li><a class="edit-category" data-toggle="modal"
                            data-target="#exampleModal" data-id="{{ $subcategory->id }}"
                            data-name="{{ $subcategory->name }}"
                            data-slug="{{ $subcategory->slug }}"
                            data-parent="{{ $subcategory->parent }}"><i class="fa fa-pencil"
                                aria-hidden="true"></i> {{ trans('file.Edit') }}</a></li>
                    <li class="divider"></li>
                    <li><a href="{{route('document.create')}}?filter_category_id={{ $subcategory->id }}"><i class="fa fa-eye"
                        aria-hidden="true"></i> {{ trans('file.Vew Documents') }}</a></li>
                    <li class="divider"></li>
                    <li>
                        <a>
                            <form method="post" action="{{ route('category.delete') }}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="category_id"
                                    value="{{ $category->id }}">
                                <button type="submit"
                                    style="display: block; background:none;border:none"><i
                                        class="fa fa-trash" aria-hidden="true"></i>
                                    {{ trans('file.Delete') }}</button>
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('categories.subcategory',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach