<h3>Events list</h3>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Déclaration</th>
      <th>Échéances</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($evenements as $evenement): ?>
    <tr>
      <td><?php echo $evenement->nom ?></td>
      <td><?php echo \Views\MonthTimeline::renderDatelines($evenement); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table
