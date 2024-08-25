//Search Table Script -->
    
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
   
        
        function editRow(icon) {
            // Find the closest <tr> ancestor of the clicked <a> tag
            const row = icon.closest('tr');
        
            // Ensure these indices correspond to the correct columns
            const Iid = row.cells[0].textContent.trim();
            const sellingPrice = row.cells[3].textContent.trim(); // Adjust index if needed
            
        
            // Fill the form fields with the data from the selected row
            document.getElementById('id').value = Iid;
            document.getElementById('selling_price').value = sellingPrice;
        }

       
        function confirmLogout(event) {
            event.preventDefault();
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'), {
                backdrop: 'static'
            });
            logoutModal.show();

            document.getElementById('confirmLogoutBtn').onclick = function () {
                window.location.href = "includes/logout.inc.php";
            };
        }
    