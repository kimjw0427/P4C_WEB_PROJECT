function on_category(){
  var category_mode = document.getElementById("on_off_category");
  var category_mode2 = document.getElementById("on_off_category2");

  var context_ = document.getElementById("context_move");

  if(category_mode.style.display != 'block'){
    category_mode.style.display = 'block';
    category_mode2.style.display = 'block';
    context_.style.marginLeft = '-250px';
  }else{
    category_mode.style.display = 'none';
    category_mode2.style.display = 'none';
    context_.style.marginLeft = '-400px';
  }
}
