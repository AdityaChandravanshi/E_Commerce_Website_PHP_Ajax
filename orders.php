<!DOCTYPE html>
<?php include 'navbar.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}
class ordered_items
{
    private $db;

    public function __construct()
    {
        $this->db = new CustomDataBase();
    }

    public function getOrdersItems()
    {
        $conn = $this->db->getConnection();
        $user_id = $_SESSION['user_id'] ?? null;
        $sql = "SELECT * FROM `ordered_items` JOIN products ON products.id = `ordered_items`.product_id WHERE `ordered_items`.user_id = '$user_id'";
        $result = $conn->query($sql);
        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }
}
$ordered_items = new ordered_items;
$ordered = $ordered_items->getOrdersItems();
?>

<style>
    h2 {
        color: darkslateblue;
    }

    table.all-orders td,
    table.all-orders tr,
    table.all-orders th {
        color: darkslateblue;
    }

    .load-btn {
        background-color: darkslateblue;
    }
</style>

<body>
    <section class="main-content paddnig80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-width">
                        <h2>Orders</h2>
                        <div class="table-block">
                            <table class="all-orders">
                                <thead>
                                    <tr>
                                        <th>ORDER</th>
                                        <th>DATE & TIME</th>
                                        <th>STATUS</th>
                                        <th>TOTAL</th>
                                    </tr>

                                    <?php if (!empty($ordered)) {
                                        foreach ($ordered as $keys => $values) {
                                    ?>
                                            <tr class="border-top">
                                                <td><?php echo $values['order_id'] ?></td>
                                                <td><?php echo $values['order_date'] ?></td>
                                                <td><strong>Shipped</strong></td>
                                                <td><strong><?php echo $values['product_price'] ?> for <?php echo $values['quantity'] ?> items</strong></td>
                                            </tr>
                                    <?php }
                                    } ?>

                                </thead>
                            </table>
                        </div>

                        <a href="#" class="load-btn">Load More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>