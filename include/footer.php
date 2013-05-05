    <hr>

    <footer>
    <p>&copy; MentorWeb 2013 - <i class="icon-book"></i> <a href="/about.php" style="color: #5a5a5a;">About</a></p>
    </footer>

    </div> <!-- /.container -->

    <script type="text/javascript">
    $(function() {
        // TODO: this can probably be a much lower interval
<?php if ($user !== null): ?>
        setInterval(checkUnreadMessageCount, 1000);
<?php endif; ?>
    });

    function checkUnreadMessageCount() {
        $.get('/api/messages/unread.php', function (responseData) {
            var response = $.parseJSON($.trim(responseData));
            var unread = response.total;
            var badge = $('#messages-unread-count');

            badge.text(unread);

            if (unread > 0) {
                badge.show();
            }
            else {
                badge.hide();
            }

            if (typeof updateUnreadMessageCounts !== "undefined") {
                updateUnreadMessageCounts(response);
            }
        });
    }
    </script>
</body>
</html>
