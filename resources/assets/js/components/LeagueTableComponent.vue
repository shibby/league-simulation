<script>
  export default {
    props: [
      'teams',
    ],
    mounted() {

    }
  }
</script>
<template>
  <div class="card card-default">
    <div class="card-header">League Table</div>
    <div class="card-body">
      <table class="table">
        <thead>
        <th>Team</th>
        <th>PTS</th>
        <th>P</th>
        <th>W</th>
        <th>D</th>
        <th>L</th>
        <th>GD</th>
        </thead>
        <tr v-for="team in teams">
          <td>{{team.name}}</td>
          <td>{{team.f_pts}}</td>
          <td>{{team.f_w + team.f_d + team.f_l}}</td>
          <td>{{team.f_w}}</td>
          <td>{{team.f_d}}</td>
          <td>{{team.f_l}}</td>
          <td>{{team.f_gd}}</td>
        </tr>
      </table>
    </div>
  </div>
</template>
