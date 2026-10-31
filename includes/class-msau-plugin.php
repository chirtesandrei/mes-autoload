<?php
if ( ! defined('ABSPATH') ) { exit; }
final class MSAU_Plugin {
	public static function boot() { add_action('admin_menu',function(){add_management_page('Mes Autoload','Mes Autoload','manage_options','mes-autoload',array(__CLASS__,'render'));}); }
	public static function report() {
		global $wpdb;
		$values=function_exists('wp_autoload_values_to_autoload')?wp_autoload_values_to_autoload():array('yes');
		$values=array_values(array_filter((array)$values,'is_string'));
		if(!$values || count($values)>10) { return array('count'=>0,'bytes'=>0,'rows'=>array(),'error'=>true); }
		$slots=implode(',',array_fill(0,count($values),'%s'));
		// Select only names and byte counts, never configuration values.
		$totals=$wpdb->get_row($wpdb->prepare("SELECT COUNT(*) AS entries, COALESCE(SUM(OCTET_LENGTH(option_value)),0) AS bytes FROM {$wpdb->options} WHERE autoload IN ($slots)",$values),ARRAY_A);
		$rows=$wpdb->get_results($wpdb->prepare("SELECT option_name, OCTET_LENGTH(option_value) AS bytes FROM {$wpdb->options} WHERE autoload IN ($slots) ORDER BY bytes DESC, option_name ASC LIMIT 50",$values),ARRAY_A);
		return array('count'=>(int)($totals['entries']??0),'bytes'=>(int)($totals['bytes']??0),'rows'=>is_array($rows)?$rows:array(),'error'=>null===$totals);
	}
	public static function render() {
		MesPlugins_Tools_V1::head('Mes Autoload');
		$r=self::report();
		if($r['error']) { echo '<p>La mesure n’a pas pu être établie. Aucun état sain n’est déduit d’une erreur de lecture.</p></div>'; return; }
		$limit=(int)apply_filters('site_status_autoloaded_options_size_limit',800000);
		echo '<p>Comprendre les données chargées automatiquement par WordPress. Cet outil ne supprime aucune option et ne modifie aucun réglage.</p>';
		echo '<h2>' . esc_html(size_format($r['bytes'],1)) . ' · ' . esc_html((string)$r['count']) . ' options</h2>';
		echo '<p>Seuil indicatif Santé du site : ' . esc_html(size_format($limit,1)) . '. ' . esc_html($r['bytes']>=$limit?'Le volume mérite un examen.':'Le volume est sous ce seuil.') . ' Ce seul nombre ne prouve ni lenteur ni rapidité.</p>';
		echo '<table class="widefat striped"><thead><tr><th>Nom de l’option</th><th>Octets stockés</th></tr></thead><tbody>';
		foreach($r['rows'] as $row) { echo '<tr><td><code>' . esc_html($row['option_name']) . '</code></td><td>' . esc_html((string)$row['bytes']) . '</td></tr>'; }
		echo '</tbody></table><p>Les 50 options les plus lourdes sont affichées, sans leur valeur. Leur nom peut suggérer une origine, mais ne prouve pas qu’une extension est encore utilisée ou qu’une option peut être effacée.</p><p>La somme correspond aux octets stockés en base pour les états d’autoload retenus par WordPress. La mémoire PHP après désérialisation et la Santé du site peuvent utiliser une autre mesure.</p></div>';
	}
}
