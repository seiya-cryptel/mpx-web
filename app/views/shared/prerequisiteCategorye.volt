{# views/shared/prerequisiteCategory.volt #}

    <ul class="nav nav_side" role="tablist">
        {#if role > 2 #} {# PlanB 以上 #}
        {% if enable_fuel_exchange_menu %}
            {# 2022/03/17 <li{% if Category2 is defined  %}{{ Category2 }}{% endif %}>{{ link_to('prerequisite/fuelandexchangee', 'Fuel Futures and FX Futures', 'target': '_blank') }}</li> #}
            <li{% if Category2 is defined  %}{{ Category2 }}{% endif %}>{{ link_to('prerequisite/fuelandexchangee', 'FX Futures', 'target': '_blank') }}</li>
        {% endif %}
        {% if enable_fuel_menu %}
            <li{% if Category4 is defined  %}{{ Category4 }}{% endif %}>{{ link_to('prerequisite/fuele', 'Assumed Fuel Price at Generation Plant', 'target': '_blank') }}{# 2019/02/08 #}</li>
        {% endif %}
        {# 2019/02/08 #}
        {% if enable_fuel_cif_menu %}
            <li{% if Category10 is defined  %}{{ Category10 }}{% endif %}>{{ link_to('prerequisite/fuelcife', 'Assumed CIF Fuel Price', 'target': '_blank') }}</li>
        {% endif %}
        {% if enable_demand_menu %}
            <li{% if Category3 is defined  %}{{ Category3 }}{% endif %}>{{ link_to('prerequisite/demandandrenewableenergye', 'Assumed Load', 'target': '_blank') }}</li>
        {% endif %}
        {% if enable_capacity_menu %}
            <li{% if Category5 is defined  %}{{ Category5 }}{% endif %}>{{ link_to('prerequisite/capacitye', 'Assumed Available Capacity of Generation', 'target': '_blank') }}</li>
        {% endif %}
        {# if role == 4 or role == 6 or role == 8 or role == 9 %} {# B2, C2, D2, admin #}
        {% if enable_connect_menu %}
            <li{% if Category7 is defined  %}{{ Category7 }}{% endif %}>{{ link_to('prerequisite/interconnecte', 'Assumed Available Capacity of Interconnector', 'target': '_blank') }}</li>
        {% endif %}
        {#if role > 2 %} {# PlanB 以上 #}
        {% if enable_jepx_menu %}
            <li{% if Category1 is defined  %}{{ Category1 }}{% endif %}>{{ link_to('prerequisite/en', 'JEPX', 'target': '_blank') }}</li>
        {% endif %}
        {# if role > 8 %} {# admin #}
        {% if enable_historical_demand_menu %}
                <li{% if Category6 is defined  %}{{ Category6 }}{% endif %}>{{ link_to('prerequisite/historicaldemande', 'Actual Load', 'target': '_blank') }}</li>
        {% endif %}
        {# All #}
        {% if enable_delivery_menu %}
            <li{% if Category8 is defined  %}{{ Category8 }}{% endif %}>{{ link_to('prerequisite/deliverymonthlye', 'Forward Curve Trends', 'target': '_blank') }}</li>
        {% endif %}
        {% if enable_delivery_distribution_menu %}
            <li{% if Category9 is defined  %}{{ Category9 }}{% endif %}>{{ link_to('prerequisite/deliverymonthlydistributione', 'Forward Curve Distribution', 'target': '_blank') }}</li>
        {% endif %}
    </ul>
    