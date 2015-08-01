<?php
namespace App\Repositories;

use App\Models\Slackintegration;
use Maknz\Slack\Client;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SlackIntegrationRepository extends AbstractRepository
{
    /**
     * @var Slack
     */
    protected $model;

    function __construct(Slackintegration $model)
    {
        $this->model = $model;
    }
    
    /**
     * Find active Slack integration for project & session company.
     * @param integer $projectId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    public function findSlackProject($projectId)
    {
        $query = $this->model
            ->newQuery()
            ->where('project_id', '=', $projectId)
            ->where('company_id', '=', \Auth::User()->company->id)
            ->where('status', '=', 'active');
        return $query->first();
    }
    
    /**
     * Send slack notification
     * @param integer $projectId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    public function sendSlackNotification($webhook, $channel, $username, $message)
    {
        // Instantiate with defaults, so all messages created
        // will be sent from 'Cyril' and to the #accounting channel
        // by default. Any names like @regan or #channel will also be linked.
        $settings = [
            'username'      => $username,
            'channel'       => $channel,
            'link_names'    => true
        ];
        $client = new Client($webhook, $settings);
        $client->send($message);
    }

}