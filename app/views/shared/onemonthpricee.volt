{# views/shared/onemonthpricee.volt #}

<table id="table_onemonthprice">
<tr>
    <th class="table_title">&nbsp;</th>
    <th class="table_title">5%&nbsp;tile</th>
    <th class="table_title">25%&nbsp;tile</th>
    {# <th>Mode</th> #}
    <th class="table_title">50%&nbsp;tile</th>
    <th class="table_title">75%&nbsp;tile</th>
    <th class="table_title">95%&nbsp;tile</th>
    <th class="table_title">Average</th>
</tr>
<tr>
    <th>{{ week_dates[0] }}~{{ week_dates[1] }} 24-hour averaged price</th>
    {% if weekly_exists[0] %}
    <td>{{ cary['w1_24h']['5percents'] }}</td>
    <td>{{ cary['w1_24h']['25percents'] }}</td>
    <td>{{ cary['w1_24h']['50percents'] }}</td>
    <td>{{ cary['w1_24h']['75percents'] }}</td>
    <td>{{ cary['w1_24h']['95percents'] }}</td>
    <td>{{ cary['w1_24h']['average'] }}</td>
    {% else %}
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    {% endif %}
</tr>
<tr>
    <th>{{ week_dates[0] }}~{{ week_dates[1] }} Daytime 8:00-18:00 averaged price</th>
    {% if weekly_exists[0] %}
    <td>{{ cary['w1_0818']['5percents'] }}</td>
    <td>{{ cary['w1_0818']['25percents'] }}</td>
    <td>{{ cary['w1_0818']['50percents'] }}</td>
    <td>{{ cary['w1_0818']['75percents'] }}</td>
    <td>{{ cary['w1_0818']['95percents'] }}</td>
    <td>{{ cary['w1_0818']['average'] }}</td>
    {% else %}
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    {% endif %}
</tr>
<tr>
    <th>{{ week_dates[2] }}~{{ week_dates[3] }} 24-hour averaged price</th>
    {% if weekly_exists[1] %}
    <td>{{ cary['w2_24h']['5percents'] }}</td>
    <td>{{ cary['w2_24h']['25percents'] }}</td>
    <td>{{ cary['w2_24h']['50percents'] }}</td>
    <td>{{ cary['w2_24h']['75percents'] }}</td>
    <td>{{ cary['w2_24h']['95percents'] }}</td>
    <td>{{ cary['w2_24h']['average'] }}</td>
    {% else %}
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    {% endif %}
</tr>
<tr>
    <th>{{ week_dates[2] }}~{{ week_dates[3] }} Daytime 8:00-18:00 averaged price</th>
    {% if weekly_exists[1] %}
    <td>{{ cary['w2_0818']['5percents'] }}</td>
    <td>{{ cary['w2_0818']['25percents'] }}</td>
    <td>{{ cary['w2_0818']['50percents'] }}</td>
    <td>{{ cary['w2_0818']['75percents'] }}</td>
    <td>{{ cary['w2_0818']['95percents'] }}</td>
    <td>{{ cary['w2_0818']['average'] }}</td>
    {% else %}
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    {% endif %}
</tr>
<tr>
    <th>{{ week_dates[4] }}~{{ week_dates[5] }} 24-hour averaged price</th>
    {% if weekly_exists[2] %}
    <td>{{ cary['w3_24h']['5percents'] }}</td>
    <td>{{ cary['w3_24h']['25percents'] }}</td>
    <td>{{ cary['w3_24h']['50percents'] }}</td>
    <td>{{ cary['w3_24h']['75percents'] }}</td>
    <td>{{ cary['w3_24h']['95percents'] }}</td>
    <td>{{ cary['w3_24h']['average'] }}</td>
    {% else %}
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    {% endif %}
</tr>
<tr>
    <th>{{ week_dates[4] }}~{{ week_dates[5] }} Daytime 8:00-18:00 averaged price</th>
    {% if weekly_exists[2] %}
    <td>{{ cary['w3_0818']['5percents'] }}</td>
    <td>{{ cary['w3_0818']['25percents'] }}</td>
    <td>{{ cary['w3_0818']['50percents'] }}</td>
    <td>{{ cary['w3_0818']['75percents'] }}</td>
    <td>{{ cary['w3_0818']['95percents'] }}</td>
    <td>{{ cary['w3_0818']['average'] }}</td>
    {% else %}
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    <td>-</td>
    {% endif %}
</tr>
</table>
