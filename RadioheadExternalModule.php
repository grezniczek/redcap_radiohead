<?php namespace RUB\RadioheadExternalModule;

require_once "classes/InjectionHelper.php";
require_once "classes/ActionTagParser.php";

/**
 * ExternalModule class for Radiohead.
 */
class RadioheadExternalModule extends \ExternalModules\AbstractExternalModule {


    const AT_RADIOHEAD = "@RADIOHEAD";

    #region Constructor and Instance Variables

    /**
     * @var InjectionHelper
     */
    public $ih = null;

    /**
     * EM Framework (tooling support)
     * @var \ExternalModules\Framework
     */
    private $fw;
 
    function __construct() {
        parent::__construct();
        $this->fw = $this->framework;
        $this->ih = InjectionHelper::init($this);
    }

    #endregion

    #region Hooks

    function redcap_data_entry_form($project_id, $record = NULL, $instrument, $event_id, $group_id = NULL, $repeat_instance = 1) {
        $this->apply_radiohead($project_id, $instrument, "dataentry");
    }

    function redcap_survey_page($project_id, $record = NULL, $instrument, $event_id, $group_id = NULL, $survey_hash, $response_id = NULL, $repeat_instance = 1) {
        $this->apply_radiohead($project_id, $instrument, "survey");
    }

    function redcap_every_page_top($project_id = null) {
        // Online Designer
        if ($project_id && defined("PAGE_FULL") && strpos(PAGE_FULL, "Design/online_designer.php") !== false) {
            $instrument = htmlentities($_GET["page"], ENT_QUOTES);
            $this->apply_radiohead($project_id, $instrument, "design");
        }
    }

    #endregion


    private function apply_radiohead($pid, $form, $mode) {
        $settings = $this->get_settings($pid, $form, self::AT_RADIOHEAD);
        $settings["mode"] = $mode;
        $this->ih->js("js/radiohead-em.js", true);
        $this->ih->css("css/radiohead-em.css", true);
        print "<script>REDCap.EM.RUB.Radiohead.init(".json_encode($settings, JSON_UNESCAPED_UNICODE).");</script>";
    }


    private function get_settings($pid, $form, $at_name) {
        $targets = [];
        $Proj = new \Project($pid);
        foreach ($Proj->forms[$form]["fields"] as $target => $_) {
            $meta = $Proj->metadata[$target];
            // Only allow certain fields
            if (!in_array($meta["element_type"], ["radio", "select", "checkbox"], true)) continue;
            $misc = $meta["misc"] ?? "";
            $choices = parseEnum($meta["element_enum"]);
            $result = ActionTagParser::parse($misc);
            foreach ($result["parts"] as $item) {
                if ($item["type"] == "tag" && $item["text"] == self::AT_RADIOHEAD) {
                    if ($item["param"]["type"] == "quoted-string") {
                        $param = trim($item["param"]["text"], "\"'");
                        $param_parts = explode(",", $param, 2);
                        $param_choice = $param_parts[0] ?? "";
                        $param_heading = $param_parts[1] ?? "";
                        if (array_key_exists($param_choice, $choices)) {
                            $targets[$target][] = [ 
                                "choice" => $param_choice,
                                "heading" => filter_tags($param_heading)
                            ];
                        }
                    }
                }

            }
        }
        return array(
            "debug" => $this->getProjectSetting("debug") == true,
            "targets" => $targets,
        );
    }
}