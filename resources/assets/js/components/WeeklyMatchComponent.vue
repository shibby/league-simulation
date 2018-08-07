<script>
  export default {
    props: [
      'week',
      'teams',
    ],
    data() {
      return {
        'matches': [],
      }
    },
    mounted() {
      this.fetchWeekResult();
    },
    methods: {
      async fetchWeekResult() {
        this.matches = (await this.$http.get(`/api/matches/${this.week}`)).data.data
      },
      async generateFixture() {
        await this.$http.post(`/api/fixture`);

        await this.fetchWeekResult()
      },
      async playWeek() {
        await this.$http.post(`/api/matches/${this.week}`)
        await this.fetchWeekResult();

        this.$bus.$emit('weekPlayed');
      },
      goToNextWeek() {
        this.$bus.$emit('weekIncreased')
      },
      goToPreviousWeek() {
        this.$bus.$emit('weekDecreased')
      },
    },
    computed: {
      weekHasBeenPlayed() {
        if (!this.matches) {
          return false;
        }
        for (let match in this.matches) {
          if (true === this.matches[match].has_been_played) {
            return true;
          }
        }

        return false;
      },
      haveNextWeek() {
        if (!this.teams.length) {
          return false;
        }

        if (this.week >= (this.teams.length - 1) * 2) {
          return false;
        }

        return true;
      }
    },
    watch: {
      'week': function () {
        console.log('watch-week', this.week)
        if (this.week) {
          this.fetchWeekResult();
        }
      }
    }
  }
</script>
<template>
  <div class="card card-default">
    <div class="card-header">Match Results</div>
    <div class="card-body" v-if="!matches || !matches.length">
      <button type="button" class="btn btn-success" @click.prevent="generateFixture()">Generate Fixture</button>
    </div>
    <div class="card-body" v-if="matches && matches.length">
      <b>{{week}}. Week Schedule</b>

      <table class="table table-striped">
        <tr v-for="match in matches">
          <td>{{match.team1.name}}</td>
          <td><strong>{{match.team1_score}}</strong></td>
          <td>-</td>
          <td><strong>{{match.team2_score}}</strong></td>
          <td>{{match.team2.name}}</td>
        </tr>
      </table>

      <button class="btn btn-success" v-show="!weekHasBeenPlayed" @click.prevent="playWeek()">Play</button>
      <button class="btn btn-success" v-show="weekHasBeenPlayed" @click.prevent="playWeek()">Re-Play</button>
      <button class="btn btn-info" v-bind:disabled="!(week > 1)" @click.prevent="goToPreviousWeek()">
        <- Go To Prev Week
      </button>
      <button class="btn btn-info" v-bind:disabled="!(weekHasBeenPlayed && haveNextWeek)" @click.prevent="goToNextWeek()">Go To
        Next Week ->
      </button>
    </div>
  </div>
</template>
