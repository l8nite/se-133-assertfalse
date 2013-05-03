    <hr>

    <footer>
    <p>&copy; MentorWeb 2013</p>
    </footer>

    </div> <!-- /.container -->


    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#logout-button').click(function() {
                window.location.replace('/api/logout.php');
            });
        });
    </script>
</body>
</html>
