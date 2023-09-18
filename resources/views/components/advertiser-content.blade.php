<section>
    <h3 class='h2 pb-3 fw-bolder'>Список офферов</h3>
    <table class='table w-75 mx-auto fs-4'>
    <tr>
      <th scope="col">Оффер</th>
      <th scope="col">Цена</th>
      <th scope="col">Статус</th>
    </tr>
    @foreach ($user->advertiser_products->all() as $product)
        <tr>
            <td class='fw-bolder'>{{$product->offer->name}}</td>
            <td>{{$product->price}} </td>
            @if ($product->status===1)
            <td class='fw-bolder text-success'>активен</td> 
            @else
            <td class='fw-bolder text-danger'>неактивен</td> 
            @endif
        </tr>
    @endforeach
    </table>
</section>