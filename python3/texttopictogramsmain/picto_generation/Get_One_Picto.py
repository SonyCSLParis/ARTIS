import requests
import json

class PictoFinder:
    def __init__(self, lang="en"):
        self.url ="https://api.arasaac.org/api/pictograms/"+lang+"/search/"

    def find_picto(self, keyword, resolution=2500):
        """

        :param keyword:
        :param resolution: only one of two values possible 500 or 2500
        :return:
        """
        response = requests.request("GET", self.url + keyword)
        if response.status_code == 200:
            id = response.json()[0]['_id']
            image_url = 'https://api.arasaac.org/v1/pictograms/' + str(id) + '?resolution='+str(resolution)
            return image_url
        else:
            print("no result")


if __name__ == '__main__':
    picto_finder = PictoFinder(lang = "en")
    picto_result = picto_finder.find_picto(keyword="quiet")
    print(picto_result)

