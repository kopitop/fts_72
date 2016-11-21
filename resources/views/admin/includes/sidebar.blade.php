<ul class="nav nav-pills nav-stacked panel panel-default sidebar">
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/subject.subject') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/subjects/create']) !!}">
                <a href="{!! action('Admin\SubjectsController@create') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.create') }}
                </a>
            </li>
            <li class="{!! set_active(['admin/subjects']) !!}">
                <a href="{!! action('Admin\SubjectsController@index') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/question.question') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/questions/create']) !!}">
                <a href="#">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.create') }}
                </a>
            </li>
            <li class="{!! set_active(['admin/questions']) !!}">
                <a href="#">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
</ul>
