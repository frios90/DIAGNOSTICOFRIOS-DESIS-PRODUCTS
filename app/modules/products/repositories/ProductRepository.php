<?php
require_once '../../../config/DatabaseConnection.php';

class ProductRepository
{
    private $pdo;

    public function __construct()
    {
        $db = DatabaseConnection::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function findByCode($code)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM products WHERE code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch();;
    }

    public function createProduct($data)
    {
        $sql = "INSERT INTO products (code, name, warehouse_id, branch_id, currency_id, price, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['code'],
            $data['name'],
            $data['warehouse'],
            $data['branch'],
            $data['currency'],
            $data['price'],
            $data['description']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function createProductMaterial($product_id, $materials)
    {
        $sql = "INSERT INTO product_material (product_id, material_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($materials as $material_id) {
            $stmt->execute([$product_id, $material_id]);
        }
    }

    public function getList()
    {
        $sql = "
            SELECT
                p.id,
                p.code,
                p.name,
                p.price,
                p.description,
                p.created_at,
                w.name as warehouse,
                b.name as branch,
                c.name as currency,
                c.symbol as currency_symbol,
                COALESCE(string_agg(m.name, ', ' ORDER BY m.name), 'No materials') as materials
            FROM products p
            LEFT JOIN warehouses w ON p.warehouse_id = w.id
            LEFT JOIN branches b ON p.branch_id = b.id
            LEFT JOIN currencies c ON p.currency_id = c.id
            LEFT JOIN product_material pm ON p.id = pm.product_id
            LEFT JOIN materials m ON pm.material_id = m.id
            GROUP BY
                p.id,
                p.code,
                p.name,
                p.price,
                p.description,
                p.created_at,
                w.name,
                b.name,
                c.name,
                c.symbol
            ORDER BY p.created_at DESC
        ";
        $stmt = $this->pdo->query($sql);
        return json_encode($stmt->fetchAll());
    }
}
?>