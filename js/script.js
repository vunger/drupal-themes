// @todo describe me 


// @todo describe me & give credit to source
/*
* Clears a field
* By: Joshua Sowin (fireandknowledge.org)
* HTML: 
*  <input type="text" value="Search" name="search" id="search" size="25"
*   onFocus="clearInput('search', 'Search')"
*   onBlur="clearInput('search', 'Search')" /> */
function clearInput(field_id, term_to_clear) {
  // Clear input if it matches default value
  if (document.getElementById(field_id).value == term_to_clear) {
    document.getElementById(field_id).value = '';
  }
  else if (document.getElementById(field_id).value == '' ) {
    // if input is empty, display the term
    document.getElementById(field_id).value = term_to_clear;
  }
} // end clearSearch()