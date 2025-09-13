<form method="POST" action="https://www.liqpay.ua/api/3/checkout" accept-charset="utf-8">
    <input type="hidden" name="data" value="{{$date}}" />
    <input type="hidden" name="signature" value="{{$signature}}" />
    <button type="submit" class="btn btn-success">Оплатити через LiqPay</button>
</form>
<script>
    document.forms[0].submit();
</script>
