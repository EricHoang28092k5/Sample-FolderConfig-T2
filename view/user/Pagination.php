<div class="pagination">
<?php
$param = "";
if (!empty($search)) $param .= "search=" . urlencode($search) . "&";
if (!empty($maLoaiSP)) $param .= "MaLoaiSP=" . (int)$maLoaiSP . "&";
if (!empty($min_price)) $param .= "min_price=" . (int)$min_price . "&";
if (!empty($max_price)) $param .= "max_price=" . (int)$max_price . "&";

if ($current_page > 3) {
    echo '<a href="?'.$param.'per_page='.$item_perpage.'&page=1">First</a>';
}
if ($current_page > 1) {
    echo '<a href="?'.$param.'per_page='.$item_perpage.'&page='.($current_page - 1).'">&lt;&lt;</a>';
}

for ($num = 1; $num <= $totalPages; $num++) {
    if ($num == $current_page) {
        echo '<strong class="current-page">'.$num.'</strong>';
    } elseif ($num > $current_page - 3 && $num < $current_page + 3) {
        echo '<a href="?'.$param.'per_page='.$item_perpage.'&page='.$num.'">'.$num.'</a>';
    }
}

if ($current_page < $totalPages) {
    echo '<a href="?'.$param.'per_page='.$item_perpage.'&page='.($current_page + 1).'">&gt;&gt;</a>';
}
if ($current_page < $totalPages - 2) {
    echo '<a href="?'.$param.'per_page='.$item_perpage.'&page='.$totalPages.'">Last</a>';
}
?>
</div>

<style>
.pagination {
  display: flex;
  justify-content: center;
  list-style: none;
  padding: 0;
  margin: 30px 0;
  align-items: center;
}
.pagination a, .pagination strong {
  text-decoration: none;
  padding: 10px 16px;
  color: white;
  background-color: #f37319;
  border-radius: 12px;
  font-weight: bold;
  margin: 0 5px;
  transition: 0.3s;
}
.pagination a:hover {
  background-color: #e55d17;
  transform: scale(1.05);
}
.pagination strong.current-page {
  background-color: #ff5100;
}
</style>
