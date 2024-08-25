            // ---------------------------------javascript code for bootstrap confirmation messages--------------------------------------------
           
            document.addEventListener('DOMContentLoaded', function () {
                var actionButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
                var confirmActionButton = document.getElementById('confirmActionButton');
                var modalBodyContent = document.getElementById('modalBodyContent');
                
                actionButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        var actionUrl = this.getAttribute('data-action');
                        var message = this.getAttribute('data-message');
                        
                        confirmActionButton.setAttribute('href', actionUrl);
                        modalBodyContent.textContent = message;
                    });
                });
            });

                            //--------------------- javascript code for search and category listing------------------------------------//

                            document.getElementById('searchInput').addEventListener('keyup', filterTable);
                            document.getElementById('categorybar').addEventListener('change', filterTable);
                    
                            function filterTable() {
                            var input, filter, categorySelect, selectedCategory, table, tr, td, i, j, txtValue, categoryValue;
                        
                            input = document.getElementById('searchInput');
                            filter = input.value.toLowerCase();
                            
                            categorySelect = document.getElementById('categorybar');
                            selectedCategory = categorySelect.value.toLowerCase();
                            
                            table = document.querySelector('.table-container table');
                            tr = table.getElementsByTagName('tr');
                    
                            console.log("Selected Category:", selectedCategory); // Debugging statement
                    
                            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                                tr[i].style.display = 'none'; // Hide the row initially
                                
                                td = tr[i].getElementsByTagName('td');
                                if (td.length > 0) {
                                    categoryValue = ((td[6].textContent) || (td[6].innerText)); // Assuming the category is in the 7th column
                                    console.log("Row Category:", categoryValue.toLowerCase()); // Debugging statement
                                    
                                    if ((selectedCategory === "") || (categoryValue.toLowerCase() === selectedCategory)) {
                                        for (j = 0; j < td.length; j++) {
                                            txtValue = ((td[j].textContent) || (td[j].innerText));
                                            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                                tr[i].style.display = ''; // Show the row if a match is found
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        
            
           //---------------------------- JavaScript to Fill the Form with Values from Selected Row -------------------------------------

function editRow(icon) {
    event.preventDefault();
    const row = icon.closest('tr');
    const Bid = row.cells[0].textContent.trim();
    const name = row.cells[1].textContent.trim();
    const quantity = row.cells[2].textContent.trim();
    const buyingPrice = row.cells[3].textContent.trim();
    const sellingPrice = row.cells[4].textContent.trim();
    const category = row.cells[6].textContent.trim();
    const description = row.cells[8].textContent.trim();
    const currentImageSrc = row.getAttribute('data-image'); // Assume you have an image URL stored

    // Fill the form fields with the data from the selected row
    document.getElementById('itemBID').value = Bid;
    document.getElementById('itemName').value = name;
    document.getElementById('itemQuantity').value = quantity;
    document.getElementById('itemBPrice').value = buyingPrice;
    document.getElementById('itemSPrice').value = sellingPrice;
    document.getElementById('itemCategory').value = category;
    document.getElementById('itemDescription').value = description;

    $('#editModal').modal('show');
}




            
                //-------------------------- js code for csv download-----------------------------------------//
                

                document.getElementById('downloadCsv').addEventListener('click', function() { // when button clicks this function calls
                    var csv = []; // empty array
                    var rows = document.querySelectorAll('.table-container table tr');//select all table rows
                
                    // Loop through the rows to construct the CSV content to print the table
                    for (var i = 0; i < rows.length; i++) {
                        var row = [], cols = rows[i].querySelectorAll('td, th');
                
                        for (var j = 0; j < cols.length-1; j++) { // putted minus 1 because action column is not needed
                            // image column is not needed
                            if (j!=7)
                            {
                            var cellContent = cols[j].innerText.replace(/"/g, '""'); // Escape double quotes and commas
                            row.push('"' + cellContent + '"');
                            }
                        }
                        csv.push(row.join(",")); 
                    }

                    
                    
                    // loop to calculate the total quantity and price  of the inventory
                    var totalQuantity = 0;
                    var totalPrice = 0;
                    for (var i =0 ; i<rows.length ; i++){ // go in all lengths
                        var cols = rows[i].querySelectorAll('td'); // get the row details
                        {
                            if (i!=0)// first line should not be count because it is header
                            {
                                var cellQuantityContent = Number(cols[2].innerText); // calculate the quantity
                                totalQuantity += cellQuantityContent;

                                var cellPriceContent = Number(cols[5].innerText); // calculate the price
                                totalPrice += cellPriceContent;
                            }
                        }
                    }

                    csv.push("Number of items = " + (rows.length-1)); // to print the total number of items in the inventory
                    csv.push("Total Quantity  = " + totalQuantity); // print total quantity
                    csv.push("Total Price  = Rs." + totalPrice); // print total Price
                

                    // Create a download link and trigger the download
                    downloadCsv(csv.join("\n"), 'table_data.csv');
                });


                function downloadCsv(csv, filename) {
                    var csvFile;
                    var downloadLink;
                
                    // Create a Blob object with the CSV data
                    csvFile = new Blob([csv], { type: 'text/csv' });
                
                    // Create a link element
                    downloadLink = document.createElement("a");
                
                    // Set the file name
                    downloadLink.download = filename;
                
                    // Create a URL for the Blob and set it as the href attribute
                    downloadLink.href = window.URL.createObjectURL(csvFile);
                
                    // Append the link to the document and trigger the download
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                }
            
                

                // ------------------------function to create and display a report on inventory------------------------- //
        
                function updateReport() {
                    var rows = document.querySelectorAll('.table-container table tbody tr');
                    var totalQuantity = 0;
                    var totalPrice = 0;
                
                    for (var i = 0; i < rows.length; i++) {
                        var cols = rows[i].querySelectorAll('td');
                        if (cols.length > 0) {
                            var quantity = parseFloat(cols[2].innerText) || 0;
                            var price = parseFloat(cols[5].innerText) || 0;
                            totalQuantity += quantity;
                            totalPrice += price;
                        }
                    }
                
                    document.getElementById('numberOfItems').innerText = "Number of items = " + rows.length;
                    document.getElementById('totalQuantity').innerText = "Total Quantity = " + totalQuantity;
                    document.getElementById('totalPrice').innerText = "Total Price = Rs. " + totalPrice.toFixed(2);
                }
                
                // Call updateReport when the page loads
                document.addEventListener('DOMContentLoaded', updateReport);
                        

                function openModal(imageSrc) {
                    // Prepend '../' to the image source
                    document.getElementById('modalImage').src = '../' + imageSrc;
                
                    // Show the modal
                    var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
                    myModal.show();
                }



                
   
