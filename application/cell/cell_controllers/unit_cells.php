<?

class Unit_cells extends Cell_Controller {
  
  public function _cache_more_tags ($more_tags, $unit) {
    return array ("time" => 60 * 60, "key" => $unit->id);
  }
  public function more_tags ($more_tags, $unit) {
    return $this->load_view (array ('more_tags' => $more_tags, 'unit' => $unit));
  }
}