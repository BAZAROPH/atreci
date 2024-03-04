@if ($commande_periode)
<script type="text/javascript">
    //Histogramme
    Highcharts.chart('barchart', {
      title: {
          text: 'Les statistiques en Fcfa'
      },
      xAxis: {
          categories: [
                @foreach ($commande_periode['commande'] as $commande )
                    "{{ $commande['period'] }}",
                @endforeach
              //'Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'
            ]
      },
      labels: {
          items: [{
              html: 'Total des entrées et des manques à gagner en fonction du temps',
              style: {
                  left: '130px',
                  top: '18px',
                  color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
              }
          }]
      },
      series: [

      {
          type: 'column',
          name: 'Gain en Fcfa',
          data: [
                @foreach ($commande_periode['commande'] as $gain_sur_com_liv)
                    {{ $gain_sur_com_liv['gain'] }},
                @endforeach
          ],
          color:'#5CB990'
      },{
          type: 'column',
          name: 'Total commande en attente',
          data: [
                @foreach ($commande_periode['commande'] as $total_com_att)
                    {{ $total_com_att['total_commande_en_attente'] }},
                @endforeach
          ],
          color:'#EEAC54'
      },{
          type: 'column',
          name: 'Total commandes annulées',
          data: [
            @foreach ($commande_periode['commande'] as $manque_gagn)
                    {{ $manque_gagn['manque_a_gagne'] }},
            @endforeach
          ],
          color:'#F71C28'
      },{
          type: 'pie',
          name: 'Total',
          data: [

          {
              name: 'Gain',
              y: {{ $commande_periode["cout_total"] }},
              color: '#5CB990'
          },{
              name: 'Total commande en attente',
              y: {{ $commande_periode["cout_total_com_att"] }},
              color: '#EEAC54'
          },{
              name: 'Total commandes annulées',
              y: {{ $commande_periode["manque_a_gagne_total"] }},
              color:'#F71C28'
          }],
          center: [40, 20],
          size: 100,
          showInLegend: false,
          dataLabels: {
              enabled: false
          }
      }]
    });

    //camembert
    Highcharts.chart('barpie', {
        title: {
            text: 'Quantité des commandes selon le statut'
        },

        series: [{
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y', 'selected', 'sliced'],
            data: [
                ['Commandes livrées', {{ $commande_periode["nombre_commande_livrer"]}}, true,true],
                ['Commandes annulées', {{ $commande_periode["nombre_commande_annuler"]}}, false],
                ['Commandes en attente',  {{ $commande_periode["nombre_commande_en_attente"]}}, false]
            ],
            showInLegend: true
        }]
    });
</script>
@endif
