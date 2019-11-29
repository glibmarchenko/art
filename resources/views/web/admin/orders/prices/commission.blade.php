@if($order->commission)
    @if(!$order->commission->pending_start_at)
        <form action="{{route('admin.commissions.approve',$order->commission)}}">
            @csrf()
            <div class="form-group" style="text-align:left;">
                <label>Коммисия</label>
                <br>
                <input type="text" name="amount" class="form-control"
                       value="{{$order->commission->amount}}">
            </div>
            <br>
            <br>
            <input type="submit"
                   class="btn btn-default btn-success"
                   value="Начислить и подтвердить">
        </form>
    @else
        <p class="btn btn-success btn-small">Начислено - {{$order->commission->amount}}
            <small>EUR</small>
        </p>

    @endif
@endif
