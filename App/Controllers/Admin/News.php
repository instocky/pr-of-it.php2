<?php
namespace App\Controllers\Admin;

use App\Controller;

class News extends Controller
{
    protected function actionIndex()
    {
        $this->view->display('index.php', ['lastNews' => \App\Models\News::findAll()]);
    }

    protected function actionEdit()
    {
        $id = $_GET['id'] ?? false;
        if (false !== $id) {
            $article = \App\Models\News::findByID($id);
        } else {
            $article = new \App\Models\News();
        }

        if (!empty($_POST)) {
            $article->fillByPost();
            if ($article->save()) {
                $this->redirect('/admin/news/index');
                exit(0);
            }
        };

        $this->view->display('edit.php',
            [
                'article' => $article,
                'authors' => \App\Models\Author::findAll(),
            ]
        );
    }

    protected function actionDelete()
    {
        $id = $_GET['id'] ?? false;
        if (false === $id) {
            $this->redirect('/admin/news/index');
            exit(0);
        }

        $article = \App\Models\News::findByID($id);
        if ($article->delete()) {
            $this->redirect('/admin/news/index');
        }
    }
}