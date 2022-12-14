<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\Linkus\Mappers;

use Modules\Linkus\Models\Linkus as LinkusModel;

class Linkus extends \Ilch\Mapper
{
    /**
     * Gets the Linkus.
     *
     * @param array $where
     * @return LinkusModel[]|array
     */
    public function getLinkus($where = [])
    {
        $entryArray = $this->db()->select('*')
            ->from('linkus')
            ->where($where)
            ->order(['id' => 'ASC'])
            ->execute()
            ->fetchRows();

        if (empty($entryArray)) {
            return null;
        }

        $linkus = [];
        foreach ($entryArray as $entries) {
            $entryModel = new LinkusModel();
            $entryModel->setId($entries['id']);
            $entryModel->setTitle($entries['title']);
            $entryModel->setBanner($entries['banner']);
            $linkus[] = $entryModel;
        }

        return $linkus;
    }

    /**
     * Gets Linkus.
     *
     * @param integer $id
     * @return LinkusModel|null
     */
    public function getLinkusById($id)
    {
        $linkusRow = $this->db()->select('*')
            ->from('linkus')
            ->where(['id' => $id])
            ->execute()
            ->fetchAssoc();

        if (empty($linkusRow)) {
            return null;
        }

        $linkusModel = new LinkusModel();
        $linkusModel->setId($linkusRow['id']);
        $linkusModel->setTitle($linkusRow['title']);
        $linkusModel->setBanner($linkusRow['banner']);

        return $linkusModel;
    }

    /**
     * Inserts or updates Linkus model.
     *
     * @param LinkusModel $linkus
     */
    public function save(LinkusModel $linkus)
    {
        $fields = [
            'title' => $linkus->getTitle(),
            'banner' => $linkus->getBanner()
        ];

        if ($linkus->getId()) {
            $this->db()->update('linkus')
                ->values($fields)
                ->where(['id' => $linkus->getId()])
                ->execute();
        } else {
            $this->db()->insert('linkus')
                ->values($fields)
                ->execute();
        }
    }

    /**
     * Deletes linkus with given id.
     *
     * @param integer $id
     */
    public function delete($id)
    {
        $this->db()->delete('linkus')
            ->where(['id' => $id])
            ->execute();
    }
}
