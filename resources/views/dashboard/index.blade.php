@extends('dashboard.layouts.mains')
@section('admin-magang')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Penjual</title>
</head>

<body>
    @cannot('superadmin')

        @cannot('admin')
            <section class="section dashboard">
                <!-- Ringkasan Penjualan -->
                <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
                    <h3>Ringkasan Penjualan</h3>
                    <div style="display: flex; justify-content: space-between; gap: 20px; margin-top: 15px;">
                        <!-- Total Produk Terjual -->
                        <div style="text-align: center; flex: 1;">
                            <div style="background-color: #007BFF; color: white; padding: 10px; border-radius: 5px; display: inline-block;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <p>Total Produk </p>
                            <p>500</p>
                        </div>

                        <!-- Pesanan Pending -->
                        <div style="text-align: center; flex: 1;">
                            <div style="background-color: #DC3545; color: white; padding: 10px; border-radius: 5px; display: inline-block;">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <p>Pesanan Pending</p>
                            <p>20</p>
                        </div>
                    </div>


                    <!-- Grafik Penjualan -->
                    <div style="margin-top: 20px;">
                        <canvas id="penjualanChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Daftar Produk Terbaru -->
                <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 15px;">
                    <h3>Daftar Produk Terbaru</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid #ccc; padding: 8px;">ID Produk</th>
                                <th style="border: 1px solid #ccc; padding: 8px;">Nama Produk</th>
                                <th style="border: 1px solid #ccc; padding: 8px;">Harga</th>
                                <th style="border: 1px solid #ccc; padding: 8px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 1px solid #ccc; padding: 8px;">1</td>
                                <td style="border: 1px solid #ccc; padding: 8px;">Produk A</td>
                                <td style="border: 1px solid #ccc; padding: 8px;">Rp. 100.000</td>
                                <td style="border: 1px solid #ccc; padding: 8px;">Aktif</td>
                            </tr>
                            <!-- Tambahkan data produk lainnya di sini -->
                        </tbody>
                    </table>
                </div>
            @endcannot()
            @can('admin')
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
                    <!-- Total Penjual -->
                    <div
                        style="display: flex; flex-direction: column; align-items: center; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-user-tie" style="font-size: 2em; margin-bottom: 10px; color: #007BFF;"></i>
                        <p>Total Penjual</p>
                        <p>50</p>
                    </div>
                    <!-- Total Pembeli -->
                    <div
                        style="display: flex; flex-direction: column; align-items: center; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-users" style="font-size: 2em; margin-bottom: 10px; color: #007BFF;"></i>
                        <p>Total Pembeli</p>
                        <p>200</p>
                    </div>
                    <!-- Total Produk -->
                    <div
                        style="display: flex; flex-direction: column; align-items: center; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-box" style="font-size: 2em; margin-bottom: 10px; color: #007BFF;"></i>
                        <p>Total Produk</p>
                        <p>1000</p>
                    </div>
                    <!-- Total Transaksi -->
                    <div
                        style="display: flex; flex-direction: column; align-items: center; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-exchange-alt" style="font-size: 2em; margin-bottom: 10px; color: #007BFF;"></i>
                        <p>Total Transaksi</p>
                        <p>500</p>
                    </div>
                </div>
            @endcan


        @endcannot
    </section>

    <!-- Footer -->
    <footer style="background-color: #f5f5f5; padding: 15px; text-align: center;">
        <span>&copy; 2024 BARBEQSHOP. All rights reserved. dhaniel.hillary.chairani.zahra</span>
    </footer>

    <!-- Script Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Inisialisasi Chart
        var ctx = document.getElementById('penjualanChart').getContext('2d');
        var penjualanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Penjualan',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>


@endsection
