<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Campaigns extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page_data["page"]->title = "Campaigns management";
        $this->page_data["page"]->menu = "campaigns";
    }

    public function index()
    {
        ifPermissions("campaigns_list");
        $globelDomain = $this->session->userdata("globelDomain");
        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            switch_db($globelDomain->domain_db_name);

            $this->page_data["campaigns_list"] = $this->campaigns_model->get();

            //switching to parent db
            switch_db(default_db_name());
        }
        $this->load->view("panel/campaigns/list", $this->page_data);
    }

    //function to show report for a campaign
    public function report($id)
    {
        ifPermissions("campaigns_list");

        $globelDomain = $this->session->userdata("globelDomain");
        $domain_id = $globelDomain->domainId;
        switch_db_by_domain_id($domain_id);

        $campaign_data = $this->campaigns_model->getById($id);
        $this->page_data["campaign_data"] = $campaign_data;

        //checking if the campaign dosnt exist
        if (empty($campaign_data)) {
            $this->session->set_flashdata("alert-type", "danger");
            $this->session->set_flashdata(
                "alert",
                'The requested page dosn\'t exist or you dont have enough permissions.'
            );
            redirect("panel/campaigns");
        }

        //checking if the campiagn is not yet launched
        $currentDatetime = new DateTime();
        $startDatetime = new DateTime($campaign_data->start_datetime);
        if ($currentDatetime < $startDatetime) {
            $this->session->set_flashdata("alert-type", "info");
            $this->session->set_flashdata(
                "alert",
                "Reporting available only once the campaign has been launched."
            );
            redirect("panel/campaigns");
        }

        $allRedocrd = [];
        $config = [];

        $config["base_url"] = base_url() . "panel/campaigns/report";
        $config["reuse_query_string"] = true;
        $config["allow_get_array"] = true;

        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
        //pagination styles configuration
        $config["full_tag_open"] = '<ul class="pagination">';
        $config["full_tag_close"] = "</ul>";

        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["prev_link"] = "‹";
        $config["prev_tag_open"] = '<li class="prev">';
        $config["prev_tag_close"] = "</li>";

        $config["next_link"] = "›";
        $config["next_tag_open"] = "<li>";
        $config["next_tag_close"] = "</li>";

        $config["cur_tag_open"] = '<li class="active"><a href="#">';
        $config["cur_tag_close"] = "</a></li>";

        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";

        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";

        $config["first_link"] = false;
        $config["last_link"] = false;

        $config[
            "total_rows"
        ] = $this->rating_responses_model->answersCountByCid($id);

        if ($config["total_rows"] > 0) {
            $this->pagination->initialize($config);
            $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;
            $this->page_data["links"] = $this->pagination->create_links();

            $allRedocrd = $this->rating_responses_model->getFilteredAnswersByCid(
                $config["per_page"],
                $page,
                $id
            );

            $this->page_data[
                "ratings_questions"
            ] = $this->ratings_model->getByWhere(["campaign_id" => $id]);

            $subscriberData = [];
            foreach ($allRedocrd as $record) {
                $subscriberData[
                    $record->subscriber_id
                ] = $this->subscribers_model->getById($record->subscriber_id);
            }
            //print_r($subscriberData);
            $this->page_data["subscribers_list"] = $subscriberData;
            $this->page_data["rating_values"] = $allRedocrd;
        } else {
            echo "no data found";
        }

        //switching to parent db
        switch_db(default_db_name());
        //loading the view
        $this->load->view("panel/campaigns/report", $this->page_data);
    }

    public function add()
    {
        ifPermissions("add_campaign");
        $globelDomain = $this->session->userdata("globelDomain");

        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            $selected_domain = $this->domains_model->getById(
                $globelDomain->domainId
            );
            if (!isset($selected_domain)) {
                ifPermissions("not_allowed");
                return;
            }
            //if not allowed to update this domain or its locations
            if (
                $selected_domain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            $this->load->view("panel/campaigns/add", $this->page_data);
        } else {
            redirect("panel/campaigns");
        }
    }

    public function save()
    {
        ifPermissions("add_campaign");
        postAllowed();

        $globelDomain = $this->session->userdata("globelDomain");
        $domain_id = $globelDomain->domainId;

        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }

            switch_db_by_domain_id($domain_id);
            //setting up the datetime objects
            // Split the date range into start and end parts
            list($startPart, $endPart) = explode(" - ", post("campaign_time"));

            // Convert start and end parts into datetime objects
            $startDatetime = date_create_from_format("m/d/Y h:i a", $startPart);
            $endDatetime = date_create_from_format("m/d/Y h:i a", $endPart);

            // Format datetime objects to MySQL DATETIME format
            $startDatetimeFormatted = $startDatetime->format("Y-m-d H:i:s");
            $endDatetimeFormatted = $endDatetime->format("Y-m-d H:i:s");

            echo "Start Datetime: $startDatetimeFormatted<br>";
            echo "End Datetime: $endDatetimeFormatted";

            // print_r($_POST);
            // exit();
            $id = $this->campaigns_model->create([
                "campaign_name" => post("name"),
                "start_datetime" => $startDatetimeFormatted,
                "end_datetime" => $endDatetimeFormatted,
                "campaign_type" => post("campaign_type"),
                "campaign_status" => (int) post("status"),
            ]);

            //switching the db back
            $globelDomain = $this->session->userdata("globelDomain");
            add_log(
                "New campaign #" .
                    $id .
                    " added by User: " .
                    $globelDomain->userName .
                    " under domain " .
                    $domain_id,
                $globelDomain
            );
            switch_db(default_db_name());
            $this->session->set_flashdata("alert-type", "success");
            $this->session->set_flashdata(
                "alert",
                "New campaign " . post("name") . " created successfully"
            );

            redirect("panel/campaigns/");
        } else {
            redirect("panel/campaigns");
        }
    }

    public function edit($id)
    {
        ifPermissions("edit_campaign");
        $globelDomain = $this->session->userdata("globelDomain");
        $domain_id = $globelDomain->domainId;

        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            switch_db_by_domain_id($domain_id);
            $get_campaign = $this->campaigns_model->getById($id);

            $this->page_data["campaign"] = $get_campaign;
            switch_db(default_db_name());
            $this->load->view("panel/campaigns/edit", $this->page_data);
        } else {
        }
    }

    public function questionnaire($id)
    {
        ifPermissions("edit_campaign");
        $globelDomain = $this->session->userdata("globelDomain");
        $domain_id = $globelDomain->domainId;

        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            switch_db_by_domain_id($domain_id);

            //enabling or disabling the star ratings
            if (!empty($_POST)) {
                //handling the rating questions saving & updates

                foreach ($_POST as $name => $value) {
                    if (strpos($name, "question") === 0) {
                        // Process the question input
                        $questionNumber = substr($name, 8); // Extract the question number

                        $this->ratingHandle($questionNumber, $value, $id);
                    }
                }
                $this->session->set_flashdata(
                    "successMes",
                    '<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered" role="alert">Your modifications are saved successfully. </div> '
                );
            } else {
                $this->session->unset_userdata("successMes");
            }

            $this->page_data["ratings"] = $this->ratings_model->getByWhere([
                "campaign_id" => $id,
            ]);
            $this->page_data["campaign_data"] = $this->campaigns_model->getById(
                $id
            );
            switch_db(default_db_name());

            $this->load->view(
                "panel/campaigns/questionnaire",
                $this->page_data
            );
        }
    }

    function delQuestion()
    {
        ifPermissions("edit_campaign");
        $globelDomain = $this->session->userdata("globelDomain");
        $domain_id = $globelDomain->domainId;

        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }
            switch_db_by_domain_id($domain_id);
            $campaignId = get("cid");
            $questionId = get("qid");

            //confirming if the question belongs to the current campaign
            $dbId = $this->ratings_model->getByWhere([
                "campaign_id" => $campaignId,
                "id" => $questionId,
            ]);

            if (isset($dbId) && !empty($dbId)) {
                $dbId = $this->ratings_model->delete($questionId);

                if ($dbId == true) {
                    echo json_encode([
                        "success" => 1,
                        "message" => "Successfully deleted",
                    ]);
                } else {
                    echo json_encode([
                        "success" => 0,
                        "message" => "There was a problem with your request",
                    ]);
                }
            }
        } else {
            echo json_encode([
                "success" => 0,
                "message" => "There was a problem with your request",
            ]);
        }
    }

    function ratingHandle($questionNumber, $questionVal, $campaignId)
    {
        $ratings_questions = $this->ratings_model->getByWhere([
            "id" => $questionNumber,
            "campaign_id" => $campaignId,
        ]);

        if (empty($ratings_questions)) {
            $this->ratings_model->create([
                "question_text" => $questionVal,
                "campaign_id" => $campaignId,
            ]);
        } else {
            //checking if the question text is similar or changed
            if ($ratings_questions[0]->question_text != $questionVal) {
                $this->ratings_model->update($questionNumber, [
                    "question_text" => $questionVal,
                ]);
            }
        }
    }

    public function update($id)
    {
        ifPermissions("edit_campaign");
        postAllowed();

        $globelDomain = $this->session->userdata("globelDomain");
        $domain_id = $globelDomain->domainId;
        switch_db_by_domain_id($domain_id);

        $status = "enable";
        list($startPart, $endPart) = explode(" - ", post("campaign_time"));

        // Convert start and end parts into datetime objects
        $startDatetime = date_create_from_format("m/d/Y h:i a", $startPart);
        $endDatetime = date_create_from_format("m/d/Y h:i a", $endPart);

        // Format datetime objects to MySQL DATETIME format
        $startDatetimeFormatted = $startDatetime->format("Y-m-d H:i:s");
        $endDatetimeFormatted = $endDatetime->format("Y-m-d H:i:s");

        echo "Start Datetime: $startDatetimeFormatted<br>";
        echo "End Datetime: $endDatetimeFormatted";

        // print_r($_POST);
        // exit();
        $id = $this->campaigns_model->update($id, [
            "campaign_name" => post("name"),
            "start_datetime" => $startDatetimeFormatted,
            "end_datetime" => $endDatetimeFormatted,
            "campaign_type" => post("campaign_type"),
            "campaign_status" => (int) post("status"),
        ]);

        //switching the db back
        $globelDomain = $this->session->userdata("globelDomain");
        add_log(
            "Campaign #" .
                $id .
                " updated by User: " .
                $globelDomain->userName .
                " under domain " .
                $domain_id,
            $globelDomain
        );
        switch_db(default_db_name());
        $this->session->set_flashdata("alert-type", "success");
        $this->session->set_flashdata("alert", "Campaign updated Successfully");

        redirect("panel/campaigns");
    }

    public function check()
    {
        $machine_name = !empty(get("machine_name"))
            ? get("machine_name")
            : false;
        $notId = !empty($this->input->get("notId"))
            ? $this->input->get("notId")
            : 0;

        if ($machine_name) {
            $exists =
                count(
                    $this->domains_model->getByWhere([
                        "domain_db_name" => $machine_name,
                        "id !=" => $notId,
                    ])
                ) > 0
                    ? true
                    : false;
        }

        echo $exists ? "false" : "true";
    }

    public function delete($id)
    {
        ifPermissions("delete_campaign");

        $globelDomain = $this->session->userdata("globelDomain");

        if (!empty($globelDomain)) {
            if (
                $globelDomain->users_id != logged("id") &&
                logged("role") != 1
            ) {
                ifPermissions("not_allowed");
                return;
            }

            switch_db_by_domain_id($globelDomain->domainId);

            $id = $this->campaigns_model->delete($id);

            //$this->activity_model->add("Campaign #$id Deleted by User:" . logged('name'));

            switch_db(default_db_name());
            $this->session->set_flashdata("alert-type", "success");
            $this->session->set_flashdata(
                "alert",
                "Campaign has been Deleted Successfully"
            );
            redirect("/panel/campaigns");
        } else {
            $this->session->set_flashdata("alert-type", "error");
            $this->session->set_flashdata("alert", 'Couldn\'t delete campaign');
            redirect("/panel/campaigns");
        }
    }

    public function change_status($id, $domain_id)
    {
        ifPermissions("edit_campaign");
        switch_db_by_domain_id($domain_id);

        $this->campaigns_model->update($id, [
            "campaign_status" => get("status") == "true" ? 1 : 0,
        ]);

        $status = get("status") == "true" ? "enabled" : "disabled";

        $globelDomain = $this->session->userdata("globelDomain");
        add_log(
            "Status " .
                $status .
                " of campaign #" .
                $id .
                " change by User (" .
                $globelDomain->userName .
                ") under domain (" .
                $globelDomain->domainName .
                ")",
            $globelDomain
        );

        //switching the db back
        switch_db(default_db_name());
        echo "done";
    }
}
