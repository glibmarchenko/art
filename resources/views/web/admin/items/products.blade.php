@extends('web.admin.layout.master')

@section('page-title', $type_name . ' (' . count($items) . ')')
@section('page-subtitle','')

@section('content')

  <div class="page-content container-fluid">
    <div class="row">
      <div class="col-md-12">
        @include('web.admin.items._navigate')
      </div>
      <div class="col-md-12">
        <div class="widget clean-widget">
          <div class="widget-body">
            <table id="users-table" cellspacing="0" width="100%"
                   class="table table-striped">
              <thead>
              <tr>
                <th></th>
                <th class="admin-avatar-column"></th>
                <th>Название</th>
                <th>Цена</th>
                <th>Статус</th>

                <th>Отклонено</th>
                <th>Проверено</th>
                <th>Топ</th>

                <th></th>
              </tr>
              </thead>
              <tbody>
              @foreach($items as $item)
                <tr id="{{$item->id}}">
                  <td style="font-size:0;">{{$item->id}}</td>
                  <td class="avatar-cell-block">
                    <img class="admin-item-avatar"
                         onclick="window.open('{{url($item->image_preview_m)}}', 'Preview', 'width=600, height=600'); return false;"
                         src="{{url($item->image_preview_s)}}">
                  </td>

                  <td>
                    <small>#{{$item->id}}</small>
                    <h4 style="margin-bottom:5px;">{{$item->name}}</h4>
                    <a href="{{$item->author->profile_url}}"
                       target="_blank">{{$item->author->name}} {{$item->author->surname}}</a>
                    <br>
                    Изменено: {{$item->updated_at->diffForHumans()}}
                    <br>
                    {{$item->width}} x {{$item->height}} @if($item->depth) x {{$item->depth}} @endif
                  </td>
                  <td class="text-center">{{$item->price}}</td>

                  <td class="text-center">
                    @lang('pages.'.$item->status) /
                    {!!  $item->for_sale ? '<span class="btn-success">Продается</span>' : 'Не для прожали' !!} /
                    {{$item->sold ? '<span class="btn-success">Продано</span>' : 'Не продано'}}
                  </td>

                  <td class="text-center">
                    <a href="{{route('admin.product.status.update',['product' => $item->id, 'status' => 2])}}"
                       class="btn {!! $item->status_id === 2 ? 'btn-warning' : 'btn-default' !!}">Отклонено</a>
                  </td>

                  <td class="text-center">
                    <a href="{{route('admin.product.status.update',['product' => $item->id, 'status' => 3])}}"
                       class="btn {!! $item->status_id === 3 ? 'btn-warning' : 'btn-default' !!}">Профиль</a>
                  </td>

                  <td class="text-center">
                    <a href="{{route('admin.product.status.update',['product' => $item->id, 'status' => 4])}}"
                       class="btn {!! $item->status_id === 4 ? 'btn-warning' : 'btn-default' !!}">Каталог</a>
                  </td>

                  <td class="text-center">
                    <a href="{{route('admin.product.status.update',['product' => $item->id, 'status' => 5])}}"
                       class="btn {!! $item->status_id === 5 ? 'btn-warning' : 'btn-default' !!}">Топ</a>
                  </td>

                  <td class="text-center">0</td>
                  <td class="text-center">
                    <a href="{{route('admin.product.edit',$item->id)}}">
                      <i class="fa fa-edit fa-2x"></i>
                    </a>
                    <a href="{{URL::to($item->image_preview_original)}}" target="_blank" download>
                      <i class="fa fa-download fa-2x"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection
