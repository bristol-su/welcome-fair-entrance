<?php

namespace App\Support\UnionCloud;

use Carbon\Carbon;
use Twigger\UnionCloud\API\UnionCloud as UnionCloudAPI;

class UnionCloud
{

    /**
     * @var UnionCloudAPI
     */
    private $unionCloud;

    public function __construct(UnionCloudAPI $unionCloud)
    {
        $this->unionCloud = $unionCloud;
    }

    public function getUidFromLibraryCard($libraryCard)
    {
        return $this->unionCloud->users()->search(['library_card' => $libraryCard])->get()->first()->uid;
    }

    public function addToUserGroup($uid, $userGroup)
    {
        try {
            $this->unionCloud->userGroupMemberships()->create($uid, $userGroup, Carbon::now()->addYears(3))->get();
        } catch (\Exception $e) {

        }
    }

    public function getStudentFromUid($uid)
    {
        return $this->unionCloud->users()->getByUID($uid)->get()->first();
    }

}
