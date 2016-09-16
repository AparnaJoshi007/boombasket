function searcha(){
var item_template='';
var query=document.getElementById('query').value;
var hostname=window.location.hostname;
$.getJSON("http://"+hostname+":9200/shopping/_search?q=Name:"+query,function(results){
console.log(results);
document.getElementById('heading').innerHTML="<h4>"+results.hits.total+" item(s) found</h4>";
if(results.hits.total>0){
 var items =results.hits.hits;
 for(var i in items){
 var cat=items[i]._type;
 var prodId=`${cat}_${items[i]._source.Name}_${items[i]._source.Quantity}`;
  item_template += `<div class="col-md-6 portfolio-item" >  
  <form method='post' action= 'addcart.php'>
  <input type= 'hidden' name='id' value='${prodId}'>
  <input type= 'hidden' name='pprice' value='${items[i]._source.Price}'>

  										<h3>${items[i]._source.Name}</h3>`
                                if(cat == 'aircraft'){
                                var name = items[i]._source.Name;
                                var name1= name.split("-"); 
                                  item_template+= `<img height="150px" width="150px" src="./images/${cat}/${name1[0]}.jpg" />`
                                  
                                }
                                else {

                                        item_template+= `<img height="150px" width="150px" src="./images/${cat}/${items[i]._source.Name}.jpg" />`}
                                        item_template+=`<p>&#8377;${items[i]._source.Price}</p>`
					if(cat != 'games' && cat != 'aircraft')
                                      item_template+=`<p>(${items[i]._source.Quantity})</p>`
item_template+=`<input type='number' name ='quant' style='width:50px;' min='1' value='1'>
   <input type='submit' value='Add to cart' class='btn btn-default' style= 'background-color : #33ACFF; color : #fff;'>
                                       </form> </div>`

}
document.getElementById('searchlist').innerHTML=item_template;
}
else
document.getElementById('searchlist').innerHTML='';
});

}



function fetchItems(cat)
{
var name=[];
	var item_template ='';
	switch(cat){
	case 'household' : 
	case 'beverages' :
	case 'personal' :$.getJSON(cat+'.json',function(items){
                                 name=items;
				for( var i in name)
				{		
					var prodId=`${cat}_${name[i].Name}_${name[i].Quantity}`;
					console.log(name[i].Name);
			 		item_template += `<div class="col-md-4" id="${cat}_${name[i].Name}_${name[i].Quantity}"> <h2>${name[i].Name}</h2> 			
					<a href="javascript:addtocart('{$i}')" > <img height="150px" width="150px" src="./img/${cat}/${name[i].Name}.jpg" /></a>
					<p> ${name[i].Price}<p>
					<p>(${name[i].Quantity})<p>
					<button class="btn btn-success" id="${prodId}" onclick="add('${prodId}')" value="Add to cart" >Add to cart</button>
					</div>`

				}
				//console.log(item_template);
				document.getElementById('list').innerHTML=item_template;
                                });
	}
	

    
}

function category(cat){
	document.getElementById("heading").innerHTML = cat.toUpperCase();
 fetchItems(cat);

}

function forcartphp(){
var total=0;
var cart = document.cookie;
if(cart=="")
 document.getElementById('list').innerHTML = "<h2>Your cart is empty</h2>";
else
{
 var cookieArray=cart.split(';');
 //cookieArray.sort();
 
 var count= cookieArray[1].split('=')[1];
 var productString = cookieArray[0].split('=')[1];
 var productList=productString.split(',');
 var item_template=`<h2>${count} items in your cart</h2><table cellspacing="50px">

   <tr>
     <th>Item </th>
     <th>&nbsp &nbsp &nbsp</th>
     <th>Price</th>
    </tr>`;
for(var i in productList)
 {
  var category=productList[i].split('_')[0];
  var name=productList[i].split('_')[1];
  var quantity=productList[i].split('_')[2];
  var price=[];
 
 


   
  $.ajax({
    url: category+'.json',
    dataType: 'json',
    async: false,
    success:function(items){
    var product=productList[i];
    for(var j in items)
    {
        if(items[j].Name==name && items[j].Quantity==quantity)
            price=items[j].Price;
    }
    total=total+parseInt(price);
  item_template+=`<tr>
   <td><img src="images/${category}/${name}.jpg" style="float:left" height="75px" width="75px" /><h4>${name}</h4></td>
   <td></td>
   <td>${price}</td>
   </tr>`;  
 
    }
  });
 
 
} 
 item_template+="</table>";
item_template+="<h2>Your order total is "+total+"Rupees</h2>"
}
document.getElementById('list').innerHTML=item_template;

}
