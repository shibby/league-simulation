<script>
  export default {
    data() {
      return {
        teams: [],
        week: 1,
      }
    },
    async mounted() {
      await this.fetchTeams();

      this.$bus.$on('weekPlayed', this.fetchTeams)
      this.$bus.$on('weekIncreased', this.increaseWeek)
      this.$bus.$on('weekDecreased', this.decreaseWeek)
    },
    methods: {
      async fetchTeams() {
        this.teams = (await this.$http.get(`/api/teams`)).data.data
      },
      async deleteFixture() {
        await this.$http.delete(`/api/fixture`);
        await this.fetchTeams();
        this.week = 0;
        var that = this
        Vue.nextTick(function () {
          that.week = 1;
        })
      },
      async deleteTeams() {
        var teamCount = prompt("How many team do you want to have in your league? (Please use even numbers)", "4");

        if (!teamCount || teamCount % 2 != 0) {
          alert('Well, this system only works with even numbers');
          return;
        }

        await this.$http.delete(`/api/fixture`);
        await this.$http.delete(`/api/teams`);
        await this.$http.post(`/api/teams`, {
          teamCount: teamCount,
        });

        await this.fetchTeams();
        this.week = 0;
        var that = this
        Vue.nextTick(function () {
          that.week = 1;
        })
      },
      increaseWeek() {
        this.week++;
      },
      decreaseWeek() {
        this.week--;
      },
    }
  }
</script>
<template>
  <div class="container">
    <div class="row">
      <div class="col-6">
        <league-table-component
            :teams="teams"
        ></league-table-component>
      </div>
      <div class="col-6">
        <weekly-match-component
            :teams="teams"
            :week="week"
        ></weekly-match-component>
      </div>
    </div>

    <div class="row" style="text-align: center;">
      <div class="col-12">
        <hr/>
        <button class="btn btn-danger" @click.prevent="deleteFixture()">
          Delete Fixture
        </button>
        <button class="btn btn-danger" @click.prevent="deleteTeams()">
          Generate New Teams
        </button>
      </div>
    </div>
  </div>
</template>
