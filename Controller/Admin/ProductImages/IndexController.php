<?php
/*
 *  Copyright 2023.  Baks.dev <admin@baks.dev>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

declare(strict_types=1);

namespace BaksDev\Avito\Products\Controller\Admin\ProductImages;

use BaksDev\Avito\Products\Repository\ProductImages\AllProductImages;
use BaksDev\Core\Controller\AbstractController;
use BaksDev\Core\Form\Search\SearchDTO;
use BaksDev\Core\Form\Search\SearchForm;
use BaksDev\Core\Listeners\Event\Security\RoleSecurity;
use BaksDev\DeliveryTransport\Repository\ProductParameter\AllProductParameter\AllProductParameterInterface;
use BaksDev\Products\Product\Forms\ProductFilter\Admin\ProductFilterDTO;
use BaksDev\Products\Product\Forms\ProductFilter\Admin\ProductFilterForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[RoleSecurity('ROLE_AVITO_PRODUCTS_INDEX')]
final class IndexController extends AbstractController
{
    #[Route('/admin/avito/product/images/{page<\d+>}', name: 'admin.product.images.index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        AllProductParameterInterface $allProductParameter,
        AllProductImages $productImages,
        int $page = 0,
    ): Response {

        // Поиск
        $search = new SearchDTO();
        $searchForm = $this->createForm(
            SearchForm::class,
            $search,
            ['action' => $this->generateUrl('avito-products:admin.product.images.index')]
        );
        $searchForm->handleRequest($request);

        /**
         * Фильтр продукции по ТП
         */
        $filter = new ProductFilterDTO($request);
        $filterForm = $this->createForm(ProductFilterForm::class, $filter, [
            'action' => $this->generateUrl('avito-products:admin.product.images.index'),
        ]);

        $filterForm->handleRequest($request);

        /** Если перезагрузить страницу */
        false === $filterForm->isSubmitted() ?: $this->redirectToReferer();

        // Получаем список
        $ProductParameter = $allProductParameter
            ->search($search)
            ->filter($filter)
            ->fetchAllProductParameterAssociative();

//        dd($productImages->findAll());

        return $this->render(
            [
                'filter' => $filterForm->createView(),
                'search' => $searchForm->createView(),
//                'query' => $ProductParameter,
                'query' => $productImages->findAll(),
            ]
        );
    }
}
