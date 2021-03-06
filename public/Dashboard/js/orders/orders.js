var product_array = new Array(10000).fill(0);
var previous_array = new Array(10000).fill(0);
var total_price=0;
var total=document.getElementById('total-price');

function get_button(event){
    var arr = event.path;
    if(arr[0].nodeName=='A')
        return arr[0];
    if(arr[1].nodeName=='A')
        return arr[1];
}
function product_add(event){
    event.preventDefault();


     var btn = get_button(event)
     var id =btn.dataset.id;
     var name=btn.dataset.name;
     var price=btn.dataset.price;
    var stock = document.getElementById('stock_'+id);
    var stock_no = parseInt(stock.innerHTML);
    var list = document.getElementById('orders-list');
    var html =document.createElement("tr");
   var  price_show = parseFloat(price).toFixed(2);
    html.innerHTML =
    `
        <tr id="product_${id}" >
        <td>${name} </td> 
         <td><input class="quantity" type="number" name="quantities[]" onchange="update_total(event)" data-id="${id}" data-price="${price}" max="${stock_no}" id="quantity-${id}" style="text-align: center; width:75%;" value="1" min="1"></td> 
          <td id="price_${id}"> ${price_show}</td>
          <td><a class="btn btn-danger" onclick="product_remove(event)" data-price="${price}" data-id="${id}" href="#"><i class="fa fa-trash"></i></a></td>
            <input type="hidden" name="product[]" value="${id}">
        </tr>
        
    `;
    html.setAttribute('id','product_'+id);
     total_price+=parseFloat(price);
     previous_array[id]=1;
    btn.classList.remove('btn-success');
    btn.classList.add('btn-default');
    btn.classList.add('disabled');

    if(!product_array[id]) {
        list.appendChild(html);
        stock_no--;
        stock.innerHTML=stock_no;
    }
    product_array[id]=1;
    show_total_price()
}

function product_remove(event){



    event.preventDefault();
    var btn=get_button(event);
    var id = btn.dataset.id;
    var price = btn.dataset.price;
    var stock = document.getElementById('stock_'+id);
    var stock_no = parseInt(stock.innerHTML);


    stock_no+=previous_array[id];

    total_price-=parseFloat(price)*previous_array[id] ;



    var removed_element= document.getElementById('product_'+id);
         removed_element.parentNode.removeChild(removed_element);
     var success_btn  =document.getElementById('product-'+id)

    success_btn.classList.remove('btn-default')
    success_btn.classList.remove('disabled')
    success_btn.classList.add('btn-success')
    product_array[id]=0;
    stock.innerHTML=stock_no;

    show_total_price()


}

function show_total_price() {
    var total=document.getElementById('total-price');

     total.innerHTML=parseInt(total_price).toFixed(2);

    var btn=document.getElementById('add_order');
    if(total_price>0){
        btn.classList.remove('disabled');

    }else {
        btn.classList.add('disabled');

    }

}

function update_total(event) {
    event.preventDefault();
    var quantities= document.getElementsByClassName('quantity');
    var target=event.target;
    console.log(quantities)
    for (var i=0 ;i<quantities.length;i++){
        var id = quantities[i].dataset.id;
        var stock = document.getElementById('stock_'+id);
        var price_element=document.getElementById('price_'+id);
        var quantity=parseInt(quantities[i].value);
        var price = parseFloat(quantities[i].dataset.price);
        var stock_no = parseInt(stock.innerHTML);
        stock_no-=quantity;
        stock_no+=+previous_array[id];
        stock.innerHTML=stock_no;

        total_price-=(price*previous_array[id]);
        previous_array[id]=quantity;
        total_price+=(quantity*price);
        console.log(total_price);
        price_element.innerHTML=(quantity*price).toFixed(2);


    }


    // var id = target.dataset.id;
    //
    //  var quantity=parseInt(target.value);
    //  var price = parseFloat(target.dataset.price);
    //  var stock_no = parseInt(stock.innerHTML);
    //  stock_no-=quantity;
    //  stock_no+=+previous_array[id];
    // stock.innerHTML=stock_no;
    //
    // total_price-=(price*previous_array[id]);
    //  previous_array[id]=quantity;
    //  total_price+=(quantity*price);

     show_total_price()
    // target.innerText;
    //
}

function show_products(event) {

    //event.preventDefault();
    var target=event.target;
    var id =target.dataset.id;
    var element=document.getElementById('show_products_'+id);
    var url=element.dataset.url;
    var method= element.dataset.method;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        var box=document.getElementById('show_data');
        if (this.readyState == 4 && this.status == 200 ){
            box.innerHTML=this.responseText;
        }
        else{
            box.innerHTML=`
            <div class="d-flex justify-content-center align-items-center" style="height: 210px;">
            <div class=" spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
                </div>`
            ;
        }
    }
    xhttp.open(method,url,1)
    xhttp.send()



}


 function edit_startup() {


}