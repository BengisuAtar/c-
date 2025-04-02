using System;

public class Dugum
{
    public int Veriler;
    public Dugum Sonraki;

    public Dugum(int veriler)
    {
        Veriler = veriler;
        Sonraki = null;
    }
}

public class TekYonluDaireselBagliListe
{
    private Dugum bas;

    // Başa ekleme işlemi
    public void BasaEkle(int veriler)
    {
        Dugum yeniDugum = new Dugum(veriler);
        if (bas == null)
        {
            bas = yeniDugum;
            yeniDugum.Sonraki = bas;
        }
        else
        {
            Dugum temp = bas;
            while (temp.Sonraki != bas)
            {
                temp = temp.Sonraki;
            }
            temp.Sonraki = yeniDugum;
            yeniDugum.Sonraki = bas;
            bas = yeniDugum;
        }
    }

    // Sona ekleme işlemi
    public void SonaEkle(int veriler)
    {
        Dugum yeniDugum = new Dugum(veriler);
        if (bas == null)
        {
            bas = yeniDugum;
            yeniDugum.Sonraki = bas;
        }
        else
        {
            Dugum temp = bas;
            while (temp.Sonraki != bas)
            {
                temp = temp.Sonraki;
            }
            temp.Sonraki = yeniDugum;
            yeniDugum.Sonraki = bas;
        }
    }

    // Araya ekleme işlemi
    public void ArayaEkle(Dugum oncekiDugum, int veriler)
    {
        if (oncekiDugum == null)
        {
            Console.WriteLine("Önceki düğüm boş olamaz.");
            return;
        }
        Dugum yeniDugum = new Dugum(veriler);
        yeniDugum.Sonraki = oncekiDugum.Sonraki;
        oncekiDugum.Sonraki = yeniDugum;
    }

    // Baştan silme işlemi
    public void BastanSil()
    {
        if (bas == null) return;

        if (bas.Sonraki == bas)
        {
            bas = null;
            return;
        }

        Dugum temp = bas;
        while (temp.Sonraki != bas)
        {
            temp = temp.Sonraki;
        }
        temp.Sonraki = bas.Sonraki;
        bas = bas.Sonraki;
    }

    // Sondan silme işlemi
    public void SondanSil()
    {
        if (bas == null) return;

        if (bas.Sonraki == bas)
        {
            bas = null;
            return;
        }

        Dugum temp = bas;
        while (temp.Sonraki.Sonraki != bas)
        {
            temp = temp.Sonraki;
        }
        temp.Sonraki = bas;
    }

    // Aradan silme işlemi
    public void AradanSil(int anahtar)
    {
        if (bas == null) return;

        if (bas.Veriler == anahtar && bas.Sonraki == bas)
        {
            bas = null;
            return;
        }

        Dugum son = bas, d = new Dugum(0);

        if (bas.Veriler == anahtar)
        {
            while (son.Sonraki != bas) son = son.Sonraki;
            son.Sonraki = bas.Sonraki;
            bas = son.Sonraki;
            return;
        }

        while (son.Sonraki != bas && son.Sonraki.Veriler != anahtar)
        {
            son = son.Sonraki;
        }

        if (son.Sonraki.Veriler == anahtar)
        {
            d = son.Sonraki;
            son.Sonraki = d.Sonraki;
        }
    }

    // Listeyi ekrana yazdırma işlemi
    public void Goruntule()
    {
        if (bas == null) return;

        Dugum temp = bas;
        do
        {
            Console.Write(temp.Veriler + " ");
            temp = temp.Sonraki;
        } while (temp != bas);
        Console.WriteLine();
    }

    // Listeyi tersten yazdırma işlemi
    public void TerstenGoruntule()
    {
        if (bas == null) return;

        Dugum temp = bas;
        Dugum son = null;
        do
        {
            son = temp;
            temp = temp.Sonraki;
        } while (temp != bas);

        do
        {
            Console.Write(son.Veriler + " ");
            temp = bas;
            while (temp.Sonraki != son)
            {
                temp = temp.Sonraki;
            }
            son = temp;
        } while (son != bas);
        Console.Write(bas.Veriler + " ");
        Console.WriteLine();
    }

    public static void Main(string[] args)
    {
        TekYonluDaireselBagliListe liste = new TekYonluDaireselBagliListe();

        liste.BasaEkle(34);
        liste.SonaEkle(27);
        liste.SonaEkle(30);
        liste.SonaEkle(40);

        Console.WriteLine("Orijinal Liste:");
        liste.Goruntule();

        liste.AradanSil(27);

        Console.WriteLine("30 silindikten sonra güncellenmiş liste:");
        liste.Goruntule();

        liste.ArayaEkle(liste.bas.Sonraki, 58);

        Console.WriteLine("20'den sonra 25 eklendikten sonra güncellenmiş liste:");
        liste.Goruntule();

        liste.BastanSil();
        Console.WriteLine("İlk eleman silindikten sonra güncellenmiş liste:");
        liste.Goruntule();

        liste.SondanSil();
        Console.WriteLine("Son eleman silindikten sonra güncellenmiş liste:");
        liste.Goruntule();

        Console.WriteLine("Listeyi tersten yazdırma:");
        liste.TerstenGoruntule();
        Console.ReadKey();  
    }
}