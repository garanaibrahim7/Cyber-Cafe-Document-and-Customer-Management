<footer>
    <!-- Your website footer can go here -->
    <p>&copy; 2025 Saher Digital Center</p>
    <?php
        if (!isset($_SESSION['name'])) {
        } else {
?>
    <a href="logout.php" class="logout-button">Log Out</a>
    
    <?php } ?>
</footer>
</body>
</html>