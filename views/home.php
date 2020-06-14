<div class="db-row">
    <div class="db-grid-3">
        <div class="db-grid-area">
            <div class="db-grid-area-count"><?php echo $products_sold; ?></div>
            <div class="db-grid-area-legend">Cusos Vendidos nos ultimos 30 dias</div>
        </div>
    </div>
    <!--
    <div class="db-grid-1">
            <div class="db-grid-area">
                    <div class="db-grid-area-count"><?php echo number_format($revenue, 2); ?></div>
                    <div class="db-grid-area-legend">Receitas nos ultimos 30 dias</div>
            </div>
    </div>
    <div class="db-grid-1">
            <div class="db-grid-area">
                    <div class="db-grid-area-count"><?php echo number_format($expenses, 2); ?></div>
                    <div class="db-grid-area-legend">Despesas nos ultimos 30 dias</div>
            </div>
    </div>
    -->
</div>

<div class="db-row">
    <div class="db-grid-2">
        <div class="db-info">
            <div class="db-info-title">
                Produtos vendidos nos ultimos 12 meses
            </div>
            <div class="db-info-body" style="height: 350px;">
                <canvas id="grafic1"></canvas>
            </div>
        </div>
    </div>
    <div class="db-grid-1">
        <div class="db-info">
            <div class="db-info-title">
                Cursos à Vencer
            </div>
            <div class="db-info-body">
                <canvas id="grafic2"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="db-row">
    <div class="db-grid-2">		
        <div class="db-info">
            <div class="db-info-title">
                Cursos à Vencer
            </div>
            <div class="db-info-body">
                <table border="0" width="100%">
                    <tr>
                        <th style="text-align: left">ID</th>
                        <th style="text-align: left">Cliente</th>
                        <th style="text-align: left">Curso</th>
                        <th style="text-align: left">Velidade</th>
                    </tr>	
                    <?php foreach ($participants_list as $p): ?>
                        <tr>
                            <td width="50"><?php echo $p['id']; ?></td>
                            <td><?php echo $p['client']; ?></td>
                            <td><?php echo $p['course']; ?></td>
                            <td width="150"><?php echo date('d/m/Y', strtotime($p['expiration_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>	
                </table>
            </div>
        </div>
    </div>
</div>

<div class="db-row"></div>

<script type="text/javascript">
    var lastMonths = <?php echo json_encode($lastMonths); ?>;
    var dataLastMonths = <?php echo json_encode($dataLastMonths); ?>;
    var nextMonths = <?php echo json_encode($nextMonths); ?>;
    var dataNextMonths = <?php echo json_encode($dataNextMonths); ?>;
</script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_home.js"></script>
