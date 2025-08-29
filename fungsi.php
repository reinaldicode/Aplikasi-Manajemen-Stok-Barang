<?php
require 'config.php';

// Ambil semua data barang
function ambilSemuaBarang($conn) {
    $sql = "SELECT * FROM barang";
    return $conn->query($sql);
}

// Tambah barang baru
function tambahBarang($conn, $nama, $stok) {
    $stmt = $conn->prepare("INSERT INTO barang (nama, stok) VALUES (?, ?)");
    $stmt->bind_param("si", $nama, $stok);
    $stmt->execute();
    $stmt->close();
}

// Hapus barang berdasarkan ID
function hapusBarang($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM barang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Kurangi stok barang
function kurangiStok($conn, $id, $jumlah) {
    $stmt = $conn->prepare("UPDATE barang SET stok = stok - ? WHERE id = ? AND stok >= ?");
    $stmt->bind_param("iii", $jumlah, $id, $jumlah);
    $stmt->execute();
    $stmt->close();
}

// Tambah stok barang
function tambahStok($conn, $id, $jumlah) {
    $stmt = $conn->prepare("UPDATE barang SET stok = stok + ? WHERE id = ?");
    $stmt->bind_param("ii", $jumlah, $id);
    $stmt->execute();
    $stmt->close();
}
