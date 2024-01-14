
<?php
// This piece of code is a function that merges 2 arrays of products into a single one and validates the existing of an item
function($p, $o, $ext) {
  $items = [];
  $sp = false;
  $cd = false;

  $ext_p = [];

  // add the data from ext array to ext_p array, creates a copy of the original array
  foreach ($ext as $i => $e) {
      $ext_p[$e['price']['id']] = $e['qty'];
  }
  // iterates each item of the data array
  foreach ($o['items']['data'] as $i => $item) {
      $product = ['id' => $item['id']]; // declares a product object with the attribute id

      // validates if the id exists and it's not null, on the ext_p array
      if (isset($ext_p[$item['price']['id']])) {
          $qty = $ext_p[$item['price']['id']]; // assigns the quantity from the ext_p array using its id
          if ($qty < 1) { 
              $product['deleted'] = true; // if the qty is < 1 then deleted boolean is set to true 
          } else {
              $product['qty'] = $qty; // if not the qty of the product is the qty from $ext_p[$item['price']['id']]
          }
          unset($ext_p[$item['price']['id']]); // removes the item to keep iterating
      } else if ($item['price']['id'] == $p['id']) { // validates if the id of the object p exists in the data array
          $sp = true; // if exists sp is set to true
      } else {
          $product['deleted'] = true; // if not, deleted is set to true
          $cd = true;
      }

      $items[] = $product; // add into the product object to the items array
  }

  if (!$sp) { // negation of sp
      $items[] = [
          'id' => $p['id'],
          'qty' => 1
      ]; // add the object with the id of p and qty 1 in the items array
  }

  foreach ($ext_p as $i => $details) { // iterate the rest of elements in the ext_p array
      if ($details['qty'] < 1) {
          continue; // if qty < 1 then keeps iterating
      }

      // add the object with the id of price and qty in the items array
      $items[] = [
          'id' => $details['price'],
          'qty' => $details['qty']
  ];
}
    
    return $items; // this returns the merged result of the 2 arrays of products
}
?>